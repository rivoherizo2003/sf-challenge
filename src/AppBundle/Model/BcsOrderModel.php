<?php
/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 03/08/2018
 * Time: 23:27
 */

namespace AppBundle\Model;


use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsOrder;
use AppBundle\Entity\BcsSetting;
use AppBundle\Entity\BcsUser;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsOrderModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /***
     * create an order via ajax
     * @param BcsUser $p_cusCustomer
     * @return BcsOrder|string
     */
    public function createOrder(BcsUser $p_cusCustomer){
        $l_ordOrder_ = $this->g_omObjectManager->getRepository(BcsOrder::class)
            ->findOneBy(array('ordStatus' => 0));
        //check is there is an order saved
        if ( is_null($l_ordOrder_) ) {
            $l_ordOrder = new BcsOrder();
            $l_ordOrder = $this->generateCodeOrder('ORD',$l_ordOrder);
            $l_ordOrder->setOrdAmount(0);
            $l_ordOrder->setOrdUser($p_cusCustomer);
            $l_ordOrder->setOrdStatus(0);
            try{
                $this->g_omObjectManager->persist($l_ordOrder);
                $this->g_omObjectManager->flush();

                return $l_ordOrder;
            } catch (\Exception $e){
                return $e->getMessage();
            }
        }
        else {
            return $l_ordOrder_;
        }
    }

    /**
     * generate code order
     * @param $p_sPrefix
     * @param BcsOrder $p_ordOrder
     * @return BcsOrder|string
     */
    public function generateCodeOrder($p_sPrefix, BcsOrder $p_ordOrder){
        $l_dtDate = new \DateTime();
        $l_setSettingModel = new BcsSettingModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_utUtility = new Utility();
        //get the last user code
        try{
            //get the row which store the last code of order added
            $l_setSetting = $this->g_omObjectManager->getRepository(BcsSetting::class)
                ->findOneBy(array('setCode' => 'SET000004'));
            if ( is_null($l_setSetting->getSetValue()) ) {
                $p_ordOrder->setOrdCode($l_utUtility->generateCode("", 1, $p_sPrefix, 1));
            }
            else {
                $p_ordOrder->setOrdCode($l_utUtility->generateCode($l_setSetting->getSetValue(), 1, $p_sPrefix, 1));
            }
            $l_setSettingModel->updateSettingValue($l_setSetting, $p_ordOrder->getOrdCode());

            return $p_ordOrder;
        } catch ( \Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * get all order of an user
     * @param BcsUser $p_usUser
     * @return BcsOrder[]|array
     */
    public function getOrderByUser(BcsUser $p_usUser){
        $l_arrOrder = $this->g_omObjectManager->getRepository(BcsOrder::class)
            ->findBy(array('ordUser' => $p_usUser));

        return $l_arrOrder;
    }

    /**
     * delete order by id
     * @param $p_iIdOrder
     * @return string
     */
    public function deleteOrder($p_iIdOrder){
        try{
            $l_ordOrder = $this->g_omObjectManager->getRepository(BcsOrder::class)->findOneBy(array('id' => $p_iIdOrder));
            $this->g_omObjectManager->remove($l_ordOrder);
            $this->g_omObjectManager->flush();

            return 'delete-order';
        } catch (\Exception $e){
            return 'error-occurred'. $e->getMessage();
        }
    }

    /**
     * task to perform after saving an order
     * @param BcsOrder $p_ordOrder
     * @return array
     */
    public function taskAfterSubmitEditOrder(BcsOrder $p_ordOrder){
        $l_sRoute = "add-order";
        if ( !$p_ordOrder->isOrdIsDraft() ) {
            $p_ordOrder->setOrdStatus(1);
            $l_sRoute = "validate-order";
        }
        $l_arrRet = array(
            'order' => $p_ordOrder,
            'route' => $l_sRoute
        );

        return $l_arrRet;
    }
}