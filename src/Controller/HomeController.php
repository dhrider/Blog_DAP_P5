<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
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

        return $this->render('Admin/Post/newPost.html.twig', array(
            'home' => $home
        ));
    }
}
