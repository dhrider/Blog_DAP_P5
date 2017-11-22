<?php
// src/Controller/ContactController.php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;

class ContactController extends Controller
{
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {

        }

        return $this->render('contactForm.html.twig', array(
           'form' => $form->createView()
        ));
    }
}
