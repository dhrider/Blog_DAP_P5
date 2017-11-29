<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\ContactType;
use App\Event\ContactEvent;
use App\Entity\Contact;

class ContactController extends Controller
{
    public function contactAction()
    {
        $em = $this->getDoctrine()->getManager();

        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $request = $this->get('request_stack')->getMasterRequest();

        $success = false;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $contactEvent = new ContactEvent($contact);

            $this->get('event_dispatcher')->dispatch(ContactEvent::CONTACT_SEND, $contactEvent);

            $em->persist($contact);
            $em->flush();

            $success = true;

            $session = $this->container->get('session');
            $session->getFlashBag()->set('success', 'You\'re message has been send.');

            $this->redirectToRoute('contact',array(
                'success' => $success
            ));
        }

        return $this->render('contactForm.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }
}
