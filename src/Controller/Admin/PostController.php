<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\PostType;

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

    public function editSinglePostAction(Post $post, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(PostType::class, $post);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $post->setDateLastModification(new \DateTime());

            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post', array(
                'id' => $post->getId()
            ));
        }

        return $this->render('Admin/Post/editSinglePost.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function managePostsAction()
    {
        return $this->render(':Admin/Post:managePosts.html.twig');
    }
}
