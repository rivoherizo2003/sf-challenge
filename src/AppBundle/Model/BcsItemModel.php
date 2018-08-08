<?php
/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 03/08/2018
 * Time: 23:27
 */

namespace AppBundle\Model;


use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsSetting;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsItemModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * this function executes some tasks after the submit of add item
     * @param $p_sPrefix
     * @param BcsItem $p_itItem
     * @return BcsItem|string
     */
    public function taskAfterSubmittingAddItem($p_sPrefix, BcsItem $p_itItem){
        $l_bcsItem = $this->generateCodeProduct($p_sPrefix, $p_itItem);

        return $l_bcsItem;
    }

    /**
     * generate code item
     * @param $p_sPrefix
     * @param BcsItem $p_itItem
     * @return BcsItem|string
     */
    public function generateCodeProduct($p_sPrefix, BcsItem $p_itItem){
        $l_dtDate = new \DateTime();
        $l_setSettingModel = new BcsSettingModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_utUtility = new Utility();
        //get the last user code
        try{
            //get the row which store the last code of item added
            $l_setSettingItem = $this->g_omObjectManager->getRepository(BcsSetting::class)
                ->findOneBy(array('setCode' => 'SET000001'));
            if ( is_null($l_setSettingItem->getSetValue()) ) {
                $p_itItem->setItmCode($l_utUtility->generateCode("", 1, $p_sPrefix, 1));
            }
            else {
                $p_itItem->setItmCode($l_utUtility->generateCode($l_setSettingItem->getSetValue(), 1, $p_sPrefix, 1));
            }
            $l_setSettingModel->updateSettingValue($l_setSettingItem, $p_itItem->getItmCode());

            return $p_itItem;
        } catch ( \Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * delete item by id
     * @param $p_IdItem
     */
    public function deleteItem($p_IdItem){
        try{
            $l_itItem = $this->g_omObjectManager->getRepository(BcsItem::class)->findOneBy(array('id' => $p_IdItem));
            $this->g_omObjectManager->remove($l_itItem);
            $this->g_omObjectManager->flush();
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * add stock
     * @param $p_arrMovementDetail
     * @return string
     */
    public function addStock($p_arrMovementDetail){
        $l_mdmMovementDetailModel = new BcsMovementDetailModel($this->g_omObjectManager, $this->g_tiTranslator);
        if ( count($p_arrMovementDetail) > 0 ) {
            foreach ( $p_arrMovementDetail as $l_mvdMovementDetail ) {
                $l_mvdMovementDetail = $l_mdmMovementDetailModel->parseMovementDetail($l_mvdMovementDetail);
                $l_itItem = $l_mvdMovementDetail->getMvdItem();
                if ( !is_null($l_itItem) ) {
                    $l_fStockQuantity = $l_itItem->getItmStockQuantity() + $l_mvdMovementDetail->getMvdQuantity();
//                    var_dump($l_fStockQuantity);die;
                    $l_itItem->setItmStockQuantity($l_fStockQuantity);
                    $l_itItem->setItmIsInActivity(true);
                    $l_itItem->setItmAvailableQuantity($l_fStockQuantity - $l_itItem->getItmReservedQuantity());
                    try{
                        $this->g_omObjectManager->flush();
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }
                unset($l_mvdMovementDetail);
            }

            return 'Stock added';
        }
        else {
            return 'Movement detail empty';
        }
    }

    /**
     * reduce stock
     * @param $p_arrMovementDetail
     * @return string
     */
    public function reduceStock($p_arrMovementDetail){
        $l_mdmMovementDetailModel = new BcsMovementDetailModel($this->g_omObjectManager, $this->g_tiTranslator);
        if ( count($p_arrMovementDetail) > 0 ) {
            foreach ( $p_arrMovementDetail as $l_mvdMovementDetail ) {
                $l_mvdMovementDetail = $l_mdmMovementDetailModel->parseMovementDetail($l_mvdMovementDetail);
                $l_itItem = $l_mvdMovementDetail->getMvdItem();
                if ( !is_null($l_itItem) ) {
                    if ( !is_null($l_mvdMovementDetail->getMvdMovement()->getMvtOrder()) ) {
                        $l_fReservedQuantity = $l_itItem->getItmReservedQuantity() - $l_mvdMovementDetail->getMvdQuantity();
                        $l_itItem->setItmReservedQuantity($l_fReservedQuantity);
                        $l_itItem->setItmIsInActivity(true);
                    }
                    $l_fStockQuantity = $l_itItem->getItmStockQuantity() - $l_mvdMovementDetail->getMvdQuantity();
                    $l_itItem->setItmStockQuantity($l_fStockQuantity);
                    $l_itItem->setItmAvailableQuantity($l_fStockQuantity - $l_itItem->getItmReservedQuantity());
                    try{
                        $this->g_omObjectManager->flush();
                    } catch (\Exception $e) {
                        return $e->getMessage();
                    }
                }
                unset($l_mvdMovementDetail);
            }

            return 'Stock added';
        }
        else {
            return 'Movement detail empty';
        }
    }
}