<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    public function loginAction(AuthenticationUtils $authenticationUtils)
    {
        $success = false;

        return $this->render('Security/login.html.twig', [
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'success' => $success
        ]);
    }

    public function loginCheckAction()
    {

    }

    public function logoutAction()
    {

    }
}
