<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class CommentController extends AbstractController
{
    public function manageCommentsAction($page, EntityManagerInterface $entityManager)
    {
        $commentRepository = $entityManager->getRepository(Comment::class);
        $adapter = new DoctrineORMAdapter($commentRepository->findAllComments(), false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($page);

        return $this->render('Admin/Comment/manageComments.html.twig', array(
            'pager' => $pager
        ));
    }

    public function deleteCommentAction(Comment $comment, EntityManagerInterface $entityManager)
    {
        $commentRepository = $entityManager->getRepository(Comment::class);
        $commentToDelete = $commentRepository->find($comment->getId());

        $entityManager->remove($commentToDelete);
        $entityManager->flush();

        return $this->redirectToRoute('manageComments');
    }

    public function validationCommentAction(Comment $comment, EntityManagerInterface $entityManager)
    {
        $comment->setValidate(true);
        $comment->setDateValidate(new \DateTime());

        $entityManager->persist($comment);
        $entityManager->flush();

        return $this->redirectToRoute('manageComments');
    }
}
