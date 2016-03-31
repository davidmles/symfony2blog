<?php

namespace Blog\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SecurityController
 */
class SecurityController extends Controller
{
    /**
     * Login
     *
     * @return Response
     *
     * @Route("/login")
     */
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render(
            'AdminBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            )
        );
    }

    /**
     * Login check
     *
     * @Route("login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * Logout
     *
     * @Route("logout")
     */
    public function logoutAction()
    {
    }
}