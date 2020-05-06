<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\Type\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class PostController extends Controller
{
    public function listPostsAction($page, EntityManagerInterface $entityManager)
    {
        // gestion de la pagination
        $postRepository = $entityManager->getRepository(Post::class)->findAllPostsDescending();
        $adapter = new DoctrineORMAdapter($postRepository, false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(4);
        $pager->setCurrentPage($page);

        return $this->render('Post/listPosts.html.twig', array(
            'pager' => $pager
        ));
    }

    public function singlePostAction(Post $post, Request $request, EntityManagerInterface $entityManager)
    {
        $comments = $entityManager->getRepository(Comment::class)->findCommentsByPostId($post->getId());
        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $success = false;

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $comment->setPost($post);

            $entityManager->persist($comment);
            $entityManager->flush();

            $success = true;

            // on prépare le message affiché à l'utilisateur quand le message est bien envoyé
            $session = $this->container->get('session');
            $session->getFlashBag()->set('success', 'Your comment awaits validation from the Administrators.');

            return $this->redirect($this->generateUrl('post',
                ['id' => $comment->getPost()->getId(),
                 'success' => $success
                ]).'#comments');
        }

        return $this->render('Post/singlePost.html.twig', array(
            'post' => $post,
            'comments' => $comments,
            'form' => $form->createView(),
            'success' => $success
        ));
    }
}
