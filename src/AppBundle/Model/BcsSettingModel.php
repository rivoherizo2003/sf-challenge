<?php
/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 04/08/2018
 * Time: 00:36
 */

namespace AppBundle\Model;


use AppBundle\Entity\BcsSetting;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsSettingModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * update value of a setting passed as parameter
     * @param BcsSetting $p_setSetting
     * @param $p_sNewValue
     */
    public function updateSettingValue(BcsSetting $p_setSetting, $p_sNewValue){
        $p_setSetting->setSetValue($p_sNewValue);
        try{
            $this->g_omObjectManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}