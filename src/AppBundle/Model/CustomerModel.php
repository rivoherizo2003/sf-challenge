<?php
/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 03/08/2018
 * Time: 23:27
 */

namespace AppBundle\Model;


use AppBundle\Entity\BcsSetting;
use AppBundle\Entity\BcsUser;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class CustomerModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * this function executes some tasks after the submit of add customer
     * @param $p_sPrefix
     * @param BcsUser $p_usrCustomer
     * @return BcsUser|string
     */
    public function taskAfterSubmittingAddCustomer($p_sPrefix, BcsUser $p_usrCustomer,UserPasswordEncoderInterface $p_ecEncoder){
        $l_umUserModel = new BcsUserModel($this->g_omObjectManager, $this->g_tiTranslator);
        $p_usrCustomer->setRoles(array('ROLE_CUSTOMER'));
        $l_sPasswordEncoded = $p_ecEncoder->encodePassword($p_usrCustomer, $p_usrCustomer->getPassword());
        $p_usrCustomer->setPassword($l_sPasswordEncoded);
        $l_bcsItem = $l_umUserModel->generateCodeUser($p_sPrefix, $p_usrCustomer);

        return $l_bcsItem;
    }
}