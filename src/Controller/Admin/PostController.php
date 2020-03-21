<?php

namespace App\Controller\Admin;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;
use App\Form\Type\PostType;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class PostController extends Controller
{
    public function newPostAction(Request $request, EntityManagerInterface $entityManager)
    {
        $post = new Post();

        $form = $this->createForm(PostType::class, $post);

        $success = false;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $entityManager->persist($post);
            $entityManager->flush();

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

    public function updatePostAction(Post $post, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(PostType::class, $post);

        if($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $post->setDateLastModification(new \DateTime());

            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('managePosts');
        }

        return $this->render('Admin/Post/updatePost.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function managePostsAction($page, PostRepository $postRepository)
    {
        $adapter = new DoctrineORMAdapter($postRepository->findAllPostsDescending(), false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(5);
        $pager->setCurrentPage($page);

        return $this->render('Admin/Post/managePosts.html.twig', array(
            'pager' => $pager
        ));
    }

    public function deletePostAction(Post $post, EntityManagerInterface $entityManager, PostRepository $postRepository)
    {
        $postToDelete = $postRepository->find($post->getId());

        $entityManager->remove($postToDelete);
        $entityManager->flush();

        return $this->redirectToRoute('managePosts');
    }
}
