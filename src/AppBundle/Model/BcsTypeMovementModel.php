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
use AppBundle\Entity\BcsTypeMovement;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsTypeMovementModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * get exit movement type
     * @return BcsTypeMovement|null|object
     */
    public function getTypeExitMovement(){
        $l_tmTypeMovementExit = $this->g_omObjectManager->getRepository(BcsTypeMovement::class)
            ->findOneBy(array('tpmCode' => 'TMV0608-000002'));

        return $l_tmTypeMovementExit;
    }
}