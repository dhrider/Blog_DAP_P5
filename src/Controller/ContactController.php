<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\ContactType;
use App\Event\ContactEvent;
use App\Entity\Contact;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ContactController extends AbstractController
{
    public function contactAction(EntityManagerInterface $entityManager, EventDispatcherInterface $eventDispatcher)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        //on récupère la requête car le render dans la vue entraine une sous-requête
        $request = $this->get('request_stack')->getMasterRequest();

        // variable utilisée pour tester le résultat de l'envoi du message
        $success = false;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $contactEvent = new ContactEvent($contact);

            $eventDispatcher->dispatch($contactEvent, ContactEvent::CONTACT_SEND);

            $entityManager->persist($contact);
            $entityManager->flush();

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
