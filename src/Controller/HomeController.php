<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        $home = true;

        return $this->render('base.html.twig', array(
            'home' => $home
        ));
    }

    public function newPostAction()
    {
        $home = false;

        return $this->render('newPost.html.twig', array(
            'home' => $home
        ));
    }
}
