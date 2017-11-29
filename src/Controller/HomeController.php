<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function homeAction()
    {
        return $this->render('base.html.twig');
    }

    public function cvAction()
    {
        return $this->render('cv.html.twig');
    }
}
