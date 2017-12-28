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

        //on récupère la requête car le render dans la vue entraine une sous-requête
        $request = $this->get('request_stack')->getMasterRequest();

        // variable utilisée pour tester le résultat de l'envoi du message
        $success = false;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $contactEvent = new ContactEvent($contact);

            $this->get('event_dispatcher')->dispatch(ContactEvent::CONTACT_SEND, $contactEvent);

            $em->persist($contact);
            $em->flush();

            // message envoyé
            $success = true;

            // on prépare le message affiché à l'utilisateur quand le message est bien envoyé
            $session = $this->container->get('session');
            $session->getFlashBag()->set('success', 'Your message has been send.');

            $this->redirectToRoute('contact',array(
                'success' => $success
            ));
        }

        return $this->render('Contact/contactForm.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }
}
