<?php
/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 04/08/2018
 * Time: 00:36
 */

namespace AppBundle\Model;


use AppBundle\Entity\BcsMovement;
use AppBundle\Entity\BcsMovementDetail;
use AppBundle\Entity\BcsOrder;
use AppBundle\Entity\BcsOrderDetail;
use AppBundle\Entity\BcsSetting;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsMovementModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * this function executes some tasks after submitting a new movement
     * @param $p_sPrefix
     * @param BcsMovement $p_mvtMovement
     * @return BcsMovement|string
     */
    public function taskAfterSubmittingAddMovement($p_sPrefix, BcsMovement $p_mvtMovement){
        $l_bcsMovement = $this->generateCodeMovement($p_sPrefix, $p_mvtMovement);
        if ( !$p_mvtMovement->isMvtIsDraft() ) {
            //if the movement was validated then update stock quantity
            $this->updateStockDependingMovementType($p_mvtMovement);
        }

        return $l_bcsMovement;
    }

    /**
     * this function executes some tasks after submitting movement's modifications
     * @param BcsMovement $p_mvtMovement
     * @return BcsMovement
     */
    public function taskAfterSubmittingEditMovement( BcsMovement $p_mvtMovement){
        if ( !$p_mvtMovement->isMvtIsDraft() ) {
            //if the movement was validated then update stock quantity
            $this->updateStockDependingMovementType($p_mvtMovement);
        }

        return $p_mvtMovement;
    }

    /**
     * update stock depending on movement type (entry or exit)
     * @param BcsMovement $p_mvtMovement
     * @return string
     */
    public function updateStockDependingMovementType(BcsMovement $p_mvtMovement){
        $l_itmItemModel = new BcsItemModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_arrMovementDetail = $this->g_omObjectManager->getRepository(BcsMovementDetail::class)
            ->findBy(array('mvdMovement' => $p_mvtMovement->getId()));
        if ( $p_mvtMovement->getMvtMovementType()->getTpmCode() == "TMV0608-000001" ){
            //stock entry
            $l_sRet = $l_itmItemModel->addStock($l_arrMovementDetail);
        }
        else if ( $p_mvtMovement->getMvtMovementType()->getTpmCode() == "TMV0608-000002" ){
            //stock exit
            $l_sRet = $l_itmItemModel->reduceStock($l_arrMovementDetail);
        }
        else {
            $l_sRet = "";
        }

        return $l_sRet;
    }

    /**
     * generate movement code
     * @param $p_sPrefix
     * @param BcsMovement $p_mvtMovement
     * @return BcsMovement|string
     */
    public function generateCodeMovement($p_sPrefix, BcsMovement $p_mvtMovement){
        $l_setSettingModel = new BcsSettingModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_utUtility = new Utility();
        //get the last user code
        try{
            //get the row which store the last code of item added
            $l_setSetting = $this->g_omObjectManager->getRepository(BcsSetting::class)
                ->findOneBy(array('setCode' => 'SET000003'));
            if ( is_null($l_setSetting->getSetValue()) ) {
                $p_mvtMovement->setMvtCode($l_utUtility->generateCode("", 1, $p_sPrefix, 1));
            }
            else {
                $p_mvtMovement->setMvtCode($l_utUtility->generateCode($l_setSetting->getSetValue(), 1, $p_sPrefix, 1));
            }
            $l_setSettingModel->updateSettingValue($l_setSetting, $p_mvtMovement->getMvtCode());

            return $p_mvtMovement;
        } catch ( \Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * delete movement by id
     * @param $p_iIdMovement
     * @return string
     */
    public function deleteMovement($p_iIdMovement){
        try{
            $l_mvtMovement = $this->g_omObjectManager->getRepository(BcsMovement::class)->findOneBy(array('id' => $p_iIdMovement));
            $this->g_omObjectManager->remove($l_mvtMovement);
            $this->g_omObjectManager->flush();

            return 'delete-movement';
        } catch (\Exception $e){
            return 'error-occurred';
        }
    }
}