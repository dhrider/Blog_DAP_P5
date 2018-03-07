<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("username", message="The username already exist. Choose another one.")
 * @UniqueEntity("email", message="The email already exist. Choose another one.")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="date_creation", type="datetime")
     */
    protected $dateCreation;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="username", type="string", unique=true)
     */
    protected $username;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="password", type="string")
     */
    protected $password;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="email", type="string", unique=true)
     * @Assert\Email()
     */
    protected $email;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="roles", type="json_array")
     */
    protected $roles;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="token", type="string")
     */
    protected $token;

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->token = hash("sha512", uniqid());
    }

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    public function getRoles()
    {
        if (null !== $this->roles)
        {
            return $this->roles;
        }

        return ['ROLE_USER'];
    }

    ////////////////////////////////////////////////////////////////////////////////

    public function getPassword()
    {
        return $this->password;
    }

    ////////////////////////////////////////////////////////////////////////////////

    public function getSalt()
    {

    }

    ////////////////////////////////////////////////////////////////////////////////

    public function getUsername()
    {
        return $this->username;
    }

    ////////////////////////////////////////////////////////////////////////////////

    public function eraseCredentials()
    {

    }

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param mixed $dateCreation
     */
    public function setDateCreation(\DateTime $dateCreation)
    {
        $this->dateCreation = $dateCreation;
    }


    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @param array $roles
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    ////////////////////////////////////////////////////////////////////////////////

    public function isAdmin()
    {
        $admin = false;

        foreach ($this->getRoles() as $role) {
            if ($role === 'ROLE_ADMIN') {
                $admin = true;
            }
        }

        return $admin;
    }

    ////////////////////////////////////////////////////////////////////////////////

    public function isSuperAdmin()
    {
        $admin = false;

        foreach ($this->getRoles() as $role) {
            if ($role === 'ROLE_SUPER_ADMIN') {
                $admin = true;
            }
        }

        return $admin;
    }
}
