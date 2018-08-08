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
use Symfony\Component\Translation\TranslatorInterface;

class BcsUserModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * generate code user
     * @param $p_sPrefix
     * @param BcsUser $p_usrUser
     * @return BcsUser|string
     */
    public function generateCodeUser($p_sPrefix, BcsUser $p_usrUser){
        $l_dtDate = new \DateTime();
        $l_setSettingModel = new BcsSettingModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_utUtility = new Utility();
        //get the last user code
        try{
            //get the row which store the last code of item added
            $l_setSetting = $this->g_omObjectManager->getRepository(BcsSetting::class)
                ->findOneBy(array('setCode' => 'SET000001'));
            if ( is_null($l_setSetting->getSetValue()) ) {
                $p_usrUser->setUsrCode($l_utUtility->generateCode("", 1, $p_sPrefix, 1));
            }
            else {
                $p_usrUser->setUsrCode($l_utUtility->generateCode($l_setSetting->getSetValue(), 1, $p_sPrefix, 1));
            }
            $l_setSettingModel->updateSettingValue($l_setSetting, $p_usrUser->getUsrCode());

            return $p_usrUser;
        } catch ( \Exception $e) {
            return $e->getMessage();
        }
    }
}