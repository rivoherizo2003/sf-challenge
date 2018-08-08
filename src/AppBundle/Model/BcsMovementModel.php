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
        if ( $p_mvtMovement->getMvtMovementType()->getTpmCode() == 'TMV0608-000002' ) {
            $p_sPrefix = "EXT";
        }
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

    /**
     * create a temporary movement for an order validated by the customer
     * after that the admin can validate the exit movement stock related to this order
     * @param BcsOrder $p_ordOrder
     * @return BcsMovement|string
     */
    public function createMovementFromOrderValidated(BcsOrder $p_ordOrder){
        $l_utUtility = new Utility();
        $this->g_omObjectManager = $l_utUtility->resetEntityManager($this->g_omObjectManager);
        $l_tdToday = new \DateTime();
        $l_tmTypeMovementModel = new BcsTypeMovementModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_mvtMovementTypeExit = $l_tmTypeMovementModel->getTypeExitMovement();
        $l_mvtMovement = new BcsMovement();
        $l_mvtMovement = $this->generateCodeMovement('EXT', $l_mvtMovement);
        $l_mvtMovement->setMvtOrder($p_ordOrder);
        $l_mvtMovement->setMvtDate($l_tdToday);
        $l_mvtMovement->setMvtComment('Stock exit movement from order '.$p_ordOrder->getOrdCode());
        $l_mvtMovement->setMvtMovementType($l_mvtMovementTypeExit);
        try{
            $this->g_omObjectManager->persist($l_mvtMovement);
            $this->g_omObjectManager->flush();
//            var_dump($l_mvtMovement);die;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        $l_odmOrderDetailModel = new BcsOrderDetailModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_arrOrderDetail = $l_odmOrderDetailModel->getOrderDetailByOrderId($p_ordOrder->getId());
//        $this->g_omObjectManager = $l_utUtility->resetEntityManager($this->g_omObjectManager);
        foreach ( $l_arrOrderDetail as $l_oddOrderDetail ) {
            $l_oddOrderDetail = $l_odmOrderDetailModel->parseOrderDetail($l_oddOrderDetail);
            $l_mvdMovementDetail = new BcsMovementDetail();
            $l_mvdMovementDetail->setMvdMovement($l_mvtMovement);
            $l_mvdMovementDetail->setMvdUnitOfMeasure($l_oddOrderDetail->getOddItem()->getItmUnitOfMeasure());
            $l_mvdMovementDetail->setMvdQuantity($l_oddOrderDetail->getOddQuantity());
            $l_mvdMovementDetail->setMvdItem($l_oddOrderDetail->getOddItem());
            //update reserved quantity
            $l_fReservedQuantity = $l_oddOrderDetail->getOddItem()->getItmReservedQuantity() + $l_oddOrderDetail->getOddQuantity();
            $l_oddOrderDetail->getOddItem()->setItmReservedQuantity($l_fReservedQuantity);
            //update available quantity
            $l_oddOrderDetail->getOddItem()->setItmAvailableQuantity($l_oddOrderDetail->getOddItem()->getItmStockQuantity() - $l_fReservedQuantity);
            //update activity item.. in order to avoid removal of the product
            $l_oddOrderDetail->getOddItem()->setItmIsInActivity(true);
            try{
                $this->g_omObjectManager->persist($l_mvdMovementDetail);
                $this->g_omObjectManager->flush();
            } catch (\Exception $e) {
                return $e->getMessage();
            }
            unset($l_oddOrderDetail);
        }

        return $l_mvtMovement;
    }
}