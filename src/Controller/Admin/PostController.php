<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostType;
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

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->persist($post);
            $em->flush();

            $success = true;

            $session = $this->container->get('session');
            $session->getFlashBag()->set('success', 'Your Post has been successfully created.');

            $this->redirectToRoute('newPost',array(
                'success' => $success
            ));
        }

        return $this->render('Admin/Post/newPost.html.twig', array(
            'form' => $form->createView(),
            'success' => $success
        ));
    }

    public function updatePostAction(Post $post, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostType::class, $post);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $post->setDateLastModification(new \DateTime());

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('managePosts');
        }

        return $this->render('Admin/Post/updatePost.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function managePostsAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $adapter = new DoctrineORMAdapter( $em->getRepository(Post::class)->findAllPostsDescending(), false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(5);
        $pager->setCurrentPage($page);

        return $this->render(':Admin/Post/managePosts.html.twig', array(
            'pager' => $pager
        ));
    }

    public function deletePostAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();

        $postToDelete = $em->getRepository(Post::class)->find($post->getId());

        $em->remove($postToDelete);
        $em->flush();

        return $this->redirectToRoute('managePosts');
    }
}
