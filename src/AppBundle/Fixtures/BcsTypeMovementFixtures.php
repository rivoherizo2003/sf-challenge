<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsItemType;
use AppBundle\Entity\BcsTypeMovement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BcsTypeMovementFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $p_omObjectManager
     */
	public function load(ObjectManager $p_omObjectManager)
	{
        $l_tmTypeMovement = new BcsTypeMovement();
        $l_tmTypeMovement->setTpmCode('TMV0608-000001');
        $l_tmTypeMovement->setTpmDescription('Entrée en stock');
        try{
            $p_omObjectManager->persist($l_tmTypeMovement);
            $p_omObjectManager->flush();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

        $l_tmTypeMovement = new BcsTypeMovement();
        $l_tmTypeMovement->setTpmCode('TMV0608-000002');
        $l_tmTypeMovement->setTpmDescription('Sortie en stock');
        try{
            $p_omObjectManager->persist($l_tmTypeMovement);
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