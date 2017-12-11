<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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

    public function listPostsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $posts = $em->getRepository(Post::class)->findAll();

        return $this->render('listPosts.html.twig', array(
            'posts' => $posts
        ));
    }
}
