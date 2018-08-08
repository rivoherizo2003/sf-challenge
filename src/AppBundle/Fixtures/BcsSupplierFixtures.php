<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsSupplier;
use AppBundle\Entity\BcsUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BcsSupplierFixtures extends Fixture
{
    const SUPPLIER_TEST_REFERENCE = 'supplier-test';

	/**
	 * Load data fixtures with the passed EntityManager
	 * @param ObjectManager $p_omObjectManager
	 *
	 * @return string
	 */
	public function load(ObjectManager $p_omObjectManager)
	{
		$l_supSupplier = new BcsSupplier();
		$l_supSupplier->setSplCode('SUP0408-000001');
		$l_supSupplier->setSplName('Supplier test');
		$l_supSupplier->setSplAddress('TANA');
		$l_supSupplier->setSplMail('supplier@gmail.com');
		$l_supSupplier->setSplPhone('033 00 000 00');

		try{
			$p_omObjectManager->persist($l_supSupplier);
			$p_omObjectManager->flush();
            $this->addReference(self::SUPPLIER_TEST_REFERENCE, $l_supSupplier);

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
		// TODO: Implement getDependencies() method.
	}
}