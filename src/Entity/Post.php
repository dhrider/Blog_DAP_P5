<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\CssSelector\Tests\Node\NegationNodeTest;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="RepositoryClass\PostRepository")
 */
class Post
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="title", type="string")
     * @Assert\NotBlank()
     */
    private $title;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="chapo", type="text")
     * @Assert\NotBlank()
     */
    private $chapo;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     */
    private $content;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="author", type="string")
     * @Assert\NotBlank()
     */
    private $author;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="date_last_modification", type="datetime")
     */
    private $dateLastModification;


    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateLastModification = new \DateTime();
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
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    /**
     * @param mixed $chapo
     */
    public function setChapo($chapo)
    {
        $this->chapo = $chapo;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDateLastModification()
    {
        return $this->dateLastModification;
    }

    /**
     * @param mixed $dateLastModification
     */
    public function setDateLastModification(\DateTime $dateLastModification)
    {
        $this->dateLastModification = $dateLastModification;
    }
}
