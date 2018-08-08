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
use AppBundle\Entity\BcsOrderDetail;
use AppBundle\Entity\BcsSetting;
use AppBundle\Entity\BcsUser;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsOrderDetailModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /***
     * create an order detail for the item to order
     * @param BcsOrder $p_ordOrder
     * @param $p_iIdItem
     * @param $p_fQuantityToOrder
     * @return string
     */
    public function createOrderDetail(BcsOrder $p_ordOrder, $p_iIdItem, $p_fQuantityToOrder){
        $l_iItItem = $this->g_omObjectManager->getRepository(BcsItem::class)->findOneBy(array('id' => $p_iIdItem));
        $l_oddOrderDetail = $this->g_omObjectManager->getRepository(BcsOrderDetail::class)
            ->findOneBy(array('oddOrder' => $p_ordOrder->getId(), 'oddItem' => $p_iIdItem));
        if ( is_null($l_oddOrderDetail) ) {
            $l_ordOrderDetail = new BcsOrderDetail();
            $l_ordOrderDetail->setOddOrder($p_ordOrder);
            $l_ordOrderDetail->setOddItem($l_iItItem);
            $l_ordOrderDetail->setOddPrice($l_iItItem->getItmPriceWithDuty());
            $l_ordOrderDetail->setOddQuantity($p_fQuantityToOrder);
            $l_ordOrderDetail->setOddUnitOfMeasure($l_iItItem->getItmUnitOfMeasure());
            //update amount order
            $l_fAmount = $p_ordOrder->getOrdAmount() + ($l_iItItem->getItmPriceWithDuty() * $p_fQuantityToOrder);
            $p_ordOrder->setOrdAmount($l_fAmount);
            try{
                $this->g_omObjectManager->persist($l_ordOrderDetail);
                $this->g_omObjectManager->flush();

                return 'item-ordered';
            } catch (\Exception $e){
                return $e->getMessage();
            }
        }
        else {
            return 'item-already-ordered';
        }

    }

    /**
     * get order detail by order id
     * @param $p_iIdOrder
     * @return BcsOrderDetail[]|array
     */
    public function getOrderDetailByOrderId($p_iIdOrder){
        $l_arrOrderDetail = $this->g_omObjectManager->getRepository(BcsOrderDetail::class)
            ->findBy(array('oddOrder' => $p_iIdOrder));

        return $l_arrOrderDetail;
    }

    /**
     * initialize order detail
     * @param BcsOrder $p_ordOrder
     * @return BcsOrder
     */
    public function initializeOrderDetail(BcsOrder $p_ordOrder){
        $l_arrOrderDetail = $this->getOrderDetailByOrderId($p_ordOrder->getId());
        if ( count($l_arrOrderDetail) > 0 ) {
            foreach ( $l_arrOrderDetail as $l_oddOrderDetail ) {
                $l_oddOrderDetail->setOddStockQuantity($l_oddOrderDetail->getOddItem()->getItmStockQuantity());
            }
        }

        return $p_ordOrder;
    }
}