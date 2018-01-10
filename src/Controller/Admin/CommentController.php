<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class CommentController extends Controller
{
    public function manageCommentsAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $adapter = new DoctrineORMAdapter( $em->getRepository(Comment::class)->findAllNonValidateComments(), false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($page);

        return $this->render(':Admin/Comment:manageComments.html.twig', array(
            'pager' => $pager
        ));
    }

    public function deleteCommentAction(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();

        $commentToDelete = $em->getRepository(Comment::class)->find($comment->getId());

        $em->remove($commentToDelete);
        $em->flush();

        return $this->redirectToRoute('manageComments');
    }

    public function validationCommentAction(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();

        $comment->setValidate(true);
        $comment->setDateValidate(new \DateTime());

        $em->persist($comment);
        $em->flush();

        return $this->redirectToRoute('manageComments');
    }
}
