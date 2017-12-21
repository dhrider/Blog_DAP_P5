<?php

namespace App\Controller;

use App\Entity\Post;
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

    public function singlePost(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $post = $em->getRepository(Post::class)->find($request->get('id'));

        if (null === $post)
        {
            throw new NotFoundHttpException("Le post d'id ".$request->get('id')." n'existe pas.");
        }

        return $this->render('singlePost.html.twig', array(
            'post' => $post
        ));
    }

    public function editSinglePost(Request $request)
    {
        return $this->render('editSinglePost.html.twig');
    }
}
