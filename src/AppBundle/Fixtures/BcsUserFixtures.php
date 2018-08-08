<?php
/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 16/04/2018
 * Time: 13:22
 */

namespace AppBundle\Fixtures;


use AppBundle\Entity\BcsUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BcsUserFixtures extends Fixture
{
	private $g_encEncoder;
    const ADMIN_USER_REFERENCE = 'admin-user';

	public function __construct(UserPasswordEncoderInterface $p_upiUserPwdEncoder) {
		$this->g_encEncoder = $p_upiUserPwdEncoder;
	}

	/**
	 * Load data fixtures with the passed EntityManager
	 * @param ObjectManager $p_omObjectManager
	 *
	 * @return string
	 */
	public function load(ObjectManager $p_omObjectManager)
	{
		$l_usrUser = new BcsUser();
		$l_usrUser->setUsrLastName("admin");
		$l_usrUser->setUsrFirstName("root");
		$l_usrUser->setUsrAddress("Tana");
		$l_usrUser->setUsrPhone("033 00 000 00");
		$l_sPwdEncoded = $this->g_encEncoder->encodePassword($l_usrUser,'admin123');
		$l_usrUser->setPassword($l_sPwdEncoded);
		$l_usrUser->setRoles(array('ROLE_ADMIN'));
		$l_usrUser->setUsrMail('admin@admin.com');
		$l_usrUser->setUsrCode('USR0101-000001');
		$l_usrUser->setUsrGender(1);

		try{
			$p_omObjectManager->persist($l_usrUser);
			$p_omObjectManager->flush();
            $this->addReference(self::ADMIN_USER_REFERENCE, $l_usrUser);

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