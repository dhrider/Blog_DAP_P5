<?php
// src/EventSubscriber/ContactEventSubscriber.php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Bundle\TwigBundle\TwigEngine;
use App\Event\ContactEvent;

class ContactEventSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $twigEngine;

    public function __construct(\Swift_Mailer $mailer, TwigEngine $twigEngine)
    {
        $this->mailer = $mailer;
        $this->twigEngine = $twigEngine;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ContactEvent::CONTACT_SEND =>array(
                ['sendContact', 20]
            )
        );
    }

    public function sendContact(ContactEvent $contactEvent)
    {
        $contact = $contactEvent->getContact();

        $email = new \Swift_Message;

        $email
            ->setSubject('Personal Blog Message')
            ->setFrom($contact->getEmail())
            ->setTo('p_bordmann@orange.fr')
            ->setContentType('text/html')
            ->setBody($this->twigEngine->render('contactEmail.html.twig',
                array('contact' => $contact))
            )
        ;

        $this->mailer->send($email);
    }
}
