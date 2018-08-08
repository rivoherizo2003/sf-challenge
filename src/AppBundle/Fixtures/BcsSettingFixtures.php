<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsSetting;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BcsSettingFixtures extends Fixture
{

	/**
	 * Load data fixtures with the passed EntityManager
	 * @param ObjectManager $p_omObjectManager
	 *
	 */
	public function load(ObjectManager $p_omObjectManager)
	{
		$l_setSetting = new BcsSetting();
		$l_setSetting->setSetCode("SET000001");
		$l_setSetting->setSetDescription("Last code item");
		try{
			$p_omObjectManager->persist($l_setSetting);
			$p_omObjectManager->flush();
		} catch (\Exception $e) {
			echo $e->getMessage();
		}

        $l_setSetting = new BcsSetting();
        $l_setSetting->setSetCode("SET000002");
        $l_setSetting->setSetDescription("Last code supplier");
        try{
            $p_omObjectManager->persist($l_setSetting);
            $p_omObjectManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $l_setSetting = new BcsSetting();
        $l_setSetting->setSetCode("SET000003");
        $l_setSetting->setSetDescription("Last code stock movement");
        try{
            $p_omObjectManager->persist($l_setSetting);
            $p_omObjectManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $l_setSetting = new BcsSetting();
        $l_setSetting->setSetCode("SET000004");
        $l_setSetting->setSetDescription("Last code order");
        try{
            $p_omObjectManager->persist($l_setSetting);
            $p_omObjectManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $l_setSetting = new BcsSetting();
        $l_setSetting->setSetCode("SET000005");
        $l_setSetting->setSetDescription("Last code user");
        try{
            $p_omObjectManager->persist($l_setSetting);
            $p_omObjectManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
	}

	/**
	 * This method must return an array of fixtures classes
	 * on which the implementing class depends on
	 *
	 * @return array
	 */
	function getDependencies()
	{
		// TODO: Implement getDependencies() method.
	}
}