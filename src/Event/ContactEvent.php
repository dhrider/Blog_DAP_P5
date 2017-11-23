<?php

namespace App\Event;

use App\Entity\Contact;
use Symfony\Component\EventDispatcher\Event;

class ContactEvent extends Event
{
    const CONTACT_SEND = 'contact.send';

    private $contact;

    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    public function getContact()
    {
        return $this->contact;
    }
}
