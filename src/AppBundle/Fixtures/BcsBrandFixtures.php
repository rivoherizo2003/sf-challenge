<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsBrand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BcsBrandFixtures extends Fixture implements DependentFixtureInterface
{

	/**
	 * Load data fixtures with the passed EntityManager
	 * @param ObjectManager $p_omObjectManager
	 *
	 * @return string
	 */
	public function load(ObjectManager $p_omObjectManager)
	{
		$l_brdBrandTest = new BcsBrand();
		$l_brdBrandTest->setBrdName('Brand test');
		$l_brdBrandTest->setBrdSupplier($this->getReference(BcsSupplierFixtures::SUPPLIER_TEST_REFERENCE));

		try{
			$p_omObjectManager->persist($l_brdBrandTest);
			$p_omObjectManager->flush();

            return 'ok';
		} catch (\Exception $e) {
			return $e->getMessage();
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
		return array(
		    BcsSupplierFixtures::class
        );
	}
}