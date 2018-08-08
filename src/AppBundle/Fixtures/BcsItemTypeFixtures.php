<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsItemType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BcsItemTypeFixtures extends Fixture
{

	/**
	 * Load data fixtures with the passed EntityManager
	 * @param ObjectManager $p_omObjectManager
	 *
	 * @return string
	 */
	public function load(ObjectManager $p_omObjectManager)
	{
        $l_arrItemType = array('Soleil', 'Vue', 'Sport');
        for ( $i = 0; $i<=count($l_arrItemType)-1; $i++ ) {
            $l_ittItemType = new BcsItemType();
            $l_ittItemType->setIttDescription($l_arrItemType[$i]);
            try{
                $p_omObjectManager->persist($l_ittItemType);
                $p_omObjectManager->flush();
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
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