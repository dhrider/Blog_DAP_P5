<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="author", type="string")
     * @Assert\NotBlank()
     */
    private $author;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank()
     */
    private $content;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="validate", type="boolean")
     */
    private $validate;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\Column(name="date_validate", type="datetime", nullable=true)
     */
    private $dateValidate;

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $post;

    ////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateValidate = null;
        $this->validate = false;
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
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * @param mixed $validate
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getDateValidate()
    {
        return $this->dateValidate;
    }

    /**
     * @param mixed $dateValidate
     */
    public function setDateValidate(\DateTime $dateValidate)
    {
        $this->dateValidate = $dateValidate;
    }

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @return mixed
     */
    public function getPost()
    {
        return $this->post;
    }

    public function setPost(Post $post)
    {
        $this->post = $post;

        return $this;
    }
}
