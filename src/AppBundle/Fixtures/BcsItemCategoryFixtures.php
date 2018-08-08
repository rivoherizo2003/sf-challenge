<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsItemCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BcsItemCategoryFixtures extends Fixture
{

    /**
     * @param ObjectManager $p_omObjectManager
     */
	public function load(ObjectManager $p_omObjectManager)
	{
	    $l_arrCategory = array('homme', 'femme', 'mixte', 'enfant');
	    for ( $i = 0; $i<=count($l_arrCategory)-1; $i++ ) {
            $l_itcItemCategory = new BcsItemCategory();
            $l_itcItemCategory->setItcDescription($l_arrCategory[$i]);
            try{
                $p_omObjectManager->persist($l_itcItemCategory);
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