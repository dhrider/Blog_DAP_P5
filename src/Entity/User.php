<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
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
     * @ORM\Column(name="username", type="string")
     */
    protected $username;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="password", type="string")
     */
    protected $password;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="email", type="string")
     */
    protected $email;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="roles", type="json_array")
     */
    protected $roles;

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
}
