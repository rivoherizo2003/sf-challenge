<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsUnitOfMeasure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BcsUnitOfMeasureFixtures extends Fixture
{

	/**
	 * Load data fixtures with the passed EntityManager
	 * @param ObjectManager $p_omObjectManager
	 *
	 */
	public function load(ObjectManager $p_omObjectManager)
	{
        $l_uomUnitOfMeasure = new BcsUnitOfMeasure();
        $l_uomUnitOfMeasure->setUomDescription('Pièce(s)');
        $l_uomUnitOfMeasure->setUomCode('Pcs');
        try{
            $p_omObjectManager->persist($l_uomUnitOfMeasure);
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