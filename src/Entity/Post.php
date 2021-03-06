<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post", cascade={"all"}, fetch="EAGER", orphanRemoval=true)
     */
    private $comments;

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

    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @param Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $comment->setPost($this);

        $this->comments[] = $comment;
    }

    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param ArrayCollection $comments
     */
    public function setComments($comments)
    {
        foreach ($comments as &$comment)
        {
            $comment->setPost($this);
        }
    }
}
