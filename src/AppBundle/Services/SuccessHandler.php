<?php
/**
 * Created by PhpStorm.
 * User: zodevopt
 * Date: 28.02.17
 * Time: 16:48
 */

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface,
	Symfony\Component\HttpFoundation\RedirectResponse,
	Symfony\Component\HttpFoundation\Request,
	Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
	Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class SuccessHandler implements AuthenticationSuccessHandlerInterface, LogoutSuccessHandlerInterface
{
	protected $l_riRouterInterface;
	protected $l_acAuthChecker;

	public function __construct(RouterInterface $p_riRouterInterface, AuthorizationCheckerInterface $p_acAuthChecker)
	{
		$this->l_riRouterInterface = $p_riRouterInterface;
		$this->l_acAuthChecker = $p_acAuthChecker;
	}

	/**
	 * launch when the user log in and success
	 * @param Request        $p_rqRequest
	 * @param TokenInterface $token
	 *
	 * @return RedirectResponse
	 */
	public function onAuthenticationSuccess(Request $p_rqRequest, TokenInterface $token)
	{
		if ( $this->l_acAuthChecker->isGranted('ROLE_ADMIN') ) {
			return new RedirectResponse($this->l_riRouterInterface->generate('adm_home'));
		}
		else {
			return new RedirectResponse($this->l_riRouterInterface->generate('cus_home'));
		}
	}

	/**
	 * Creates a Response object to send upon a successful logout.
	 *
	 * @param Request $request
	 *
	 * @return Response never null
	 */
	public function onLogoutSuccess(Request $request)
	{
		return new RedirectResponse($this->l_riRouterInterface->generate('homepage'));;
	}
}