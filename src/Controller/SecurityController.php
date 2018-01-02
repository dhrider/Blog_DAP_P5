<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render(':Security:login.html.twig', [
        'last_username' => $helper->getLastUsername(),
        'error' => $helper->getLastAuthenticationError()
    ]);
    }

    public function loginCheckAction()
    {

    }

    public function logoutAction()
    {

    }
}
