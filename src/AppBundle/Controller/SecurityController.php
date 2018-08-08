<?php

namespace AppBundle\Controller;

use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;

class SecurityController extends AbstractController
{
	private $g_trTranslator;
	private $g_docDoctrine;
	private $g_envEnvironment;
	private $g_ciContainerInterface;
	private $g_upeUserPasswordEncoder;

	/**
	 * UserController constructor.
	 * @param TranslatorInterface $g_trTranslator
	 * @param RegistryInterface $g_docDoctrine
	 * @param Environment $g_envEnvironment
	 * @param ContainerInterface $p_ciContainerInterface
	 * @param UserPasswordEncoderInterface $p_upeUserPasswordEncoder
	 */
	const P_S_MAIL = "p_sMail";

	public function __construct(TranslatorInterface $g_trTranslator, RegistryInterface $g_docDoctrine,
	                            Environment $g_envEnvironment, ContainerInterface $p_ciContainerInterface,
	                            UserPasswordEncoderInterface $p_upeUserPasswordEncoder)
	{
		$this->g_trTranslator = $g_trTranslator;
		$this->g_docDoctrine = $g_docDoctrine;
		$this->g_envEnvironment = $g_envEnvironment;
		$this->g_ciContainerInterface = $p_ciContainerInterface;
		$this->g_upeUserPasswordEncoder = $p_upeUserPasswordEncoder;
	}

	/**
	 * @Route("/secured/login", name="login")
	 * @param AuthenticationUtils $p_auAuthenticationUtils
	 *
	 * @return Response
	 */
    public function loginAction(AuthenticationUtils $p_auAuthenticationUtils){
//        die('ici');
    	//get the login error if there is one
	    $l_aeAuthenticationError = $p_auAuthenticationUtils->getLastAuthenticationError();
	    //get the last username entered by the user
	    $l_sLastUserName = $p_auAuthenticationUtils->getLastUsername();

        return $this->render('signIn/login.html.twig', [
            'p_sLastUserName' => $l_sLastUserName,
            'p_aeAuthenticationError' => $l_aeAuthenticationError,
        ]);
    }

	/**
	 * @Route("/secured/login_check", name="login_check")
	 */
	public function loginCheckAction()
	{
		// this controller will not be executed,
		// as the route is handled by the Security system
	}
}
