<?php
// src/Entity/Contact.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="contact")
 * @ORM\Entity(repositoryClass="Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="first_name", type="string")
     * @Assert\NotBlank()
     */
    private $firstName;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="last_name", type="string")
     * @Assert\NotBlank()
     */
    private $lastName;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="email", type="string")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     */
    private $email;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="message", type="text")
     * @Assert\NotBlank()
     */
    private $message;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        $this->date = new \DateTime();
    }

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }
}
