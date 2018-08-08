<?php
/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 04/08/2018
 * Time: 00:36
 */

namespace AppBundle\Model;


use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsMovement;
use AppBundle\Entity\BcsMovementDetail;
use AppBundle\Entity\BcsOrder;
use AppBundle\Entity\BcsOrderDetail;
use AppBundle\Entity\BcsSetting;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsMovementDetailModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * initialize movement detail
     * @param BcsMovement $p_mvtMovement
     * @return BcsMovement
     */
    public function initializeMovementDetail(BcsMovement $p_mvtMovement){
        $l_arrMovementDetail = $this->g_omObjectManager->getRepository(BcsMovementDetail::class)
            ->findBy(array('mvdMovement' => $p_mvtMovement->getId()));
        if ( count($l_arrMovementDetail) > 0 ) {
            foreach ( $l_arrMovementDetail as $l_mvdMovementDetail ) {
                $l_mvdMovementDetail->setMvdStockQuantity($l_mvdMovementDetail->getMvdItem()->getItmAvailableQuantity());
            }
        }

        return $p_mvtMovement;
    }

    /**
     * @param BcsMovementDetail $p_mvdMovementDetail
     * @return BcsMovementDetail
     */
    public function parseMovementDetail(BcsMovementDetail $p_mvdMovementDetail){
        return $p_mvdMovementDetail;
    }

    /**
     * get movement detail for an item
     * @param BcsItem $p_itItem
     * @return BcsMovementDetail[]|array
     */
    public function getMovementDetailByItem(BcsItem $p_itItem){
        $l_arrMovementDetail = $this->g_omObjectManager->getRepository(BcsMovementDetail::class)
            ->findBy(array('mvdItem' => $p_itItem->getId()));

        return $l_arrMovementDetail;
    }
}