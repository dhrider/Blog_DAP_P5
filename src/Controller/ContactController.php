<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Event\ContactEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Contact;

class ContactController extends Controller
{
    public function contactAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $request = $this->get('request_stack')->getMasterRequest();

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $contactEvent = new ContactEvent($contact);

            $this->get('event_dispatcher')->dispatch(ContactEvent::CONTACT_SEND, $contactEvent);

            $em->persist($contact);
            $em->flush();

            $this->redirectToRoute('home');
        }

        return $this->render('contactForm.html.twig', array(
           'form' => $form->createView()
        ));
    }
}
