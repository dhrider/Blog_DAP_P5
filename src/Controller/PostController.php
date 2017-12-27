<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class PostController extends Controller
{
    public function newPostAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $success = false;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $em->persist($post);
            $em->flush();

            $success = true;

            $session = $this->container->get('session');
            $session->getFlashBag()->set('success', 'Votre post a bien été crée.');

            $this->redirectToRoute('newPost',array(
                'success' => $success
            ));
        }

        return $this->render('newPost.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }

    public function listPostsAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        // gestion de la pagination
        $adapter = new DoctrineORMAdapter($em->getRepository(Post::class)->findAllPostsDescending(), false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(4);
        $pager->setCurrentPage($page);

        return $this->render('listPosts.html.twig', array(
            'pager' => $pager
        ));
    }

    public function singlePost(Post $post, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $comments = $em->getRepository(Comment::class)->findCommentsByPostId($post->getId());

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $comment->setPost($post);

            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('post',
                ['id' => $comment->getPost()->getId()]).'#comments')
            ;
        }

        return $this->render('singlePost.html.twig', array(
            'post' => $post,
            'comments' => $comments,
            'form' => $form->createView()
        ));
    }

    public function editSinglePost(Post $post, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostType::class, $post);


        if($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $post->setDateLastModification(new \DateTime());

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post', array(
               'id' => $post->getId()
            ));
        }

        return $this->render('editSinglePost.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
