<?php
// src/Controller/ContactController.php

namespace App\Controller;

use App\Form\ContactType;
use App\Event\ContactEvent;
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

        dump($form->handleRequest($request));
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            var_dump('test');

            $contactEvent = new ContactEvent($contact);

            $this->get('event_dispatcher')->dispatch(ContactEvent::CONTACT_SEND, $contactEvent);

            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('contactForm.html.twig', array(
           'form' => $form->createView()
        ));
    }
}
