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
use AppBundle\Entity\BcsSupplier;
use AppBundle\Services\Utility;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Translation\TranslatorInterface;

class BcsSupplierModel
{
    private $g_omObjectManager;
    private $g_tiTranslator;
    public function __construct(ObjectManager $p_omObjectManager, TranslatorInterface $p_tiTranslator)
    {
        $this->g_omObjectManager = $p_omObjectManager;
        $this->g_tiTranslator = $p_tiTranslator;
    }

    /**
     * this function executes some tasks after submitting a new supplier
     * @param $p_sPrefix
     * @param BcsItem $p_itItem
     * @return BcsItem|string
     */
    public function taskAfterSubmittingAddSupplier($p_sPrefix, BcsSupplier $p_supSupplier){
        $l_bcsItem = $this->generateCodeSupplier($p_sPrefix, $p_supSupplier);

        return $l_bcsItem;
    }

    /**
     * generate code item
     * @param $p_sPrefix
     * @param BcsSupplier $p_supSupplier
     * @return BcsSupplier|string
     */
    public function generateCodeSupplier($p_sPrefix, BcsSupplier $p_supSupplier){
        $l_setSettingModel = new BcsSettingModel($this->g_omObjectManager, $this->g_tiTranslator);
        $l_utUtility = new Utility();
        //get the last user code
        try{
            //get the row which store the last code of item added
            $l_setSettingSupplier = $this->g_omObjectManager->getRepository(BcsSetting::class)
                ->findOneBy(array('setCode' => 'SET000002'));
            if ( is_null($l_setSettingSupplier->getSetValue()) ) {
                $p_supSupplier->setSplCode($l_utUtility->generateCode("", 1, $p_sPrefix, 1));
            }
            else {
                $p_supSupplier->setSplCode($l_utUtility->generateCode($l_setSettingSupplier->getSetValue(), 1, $p_sPrefix, 1));
            }
            $l_setSettingModel->updateSettingValue($l_setSettingSupplier, $p_supSupplier->getSplCode());

            return $p_supSupplier;
        } catch ( \Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * delete supplier by id
     * @param $p_iIdSupplier
     * @return string
     */
    public function deleteSupplier($p_iIdSupplier){
        try{
            $l_supSupplier = $this->g_omObjectManager->getRepository(BcsSupplier::class)->findOneBy(array('id' => $p_iIdSupplier));
            $this->g_omObjectManager->remove($l_supSupplier);
            $this->g_omObjectManager->flush();

            return 'delete-supplier';
        } catch (\Exception $e){
            return 'error-occurred';
        }
    }
}