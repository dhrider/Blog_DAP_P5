<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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

    /**
     * @param $page
     * @Route("/listPosts/{page}", name="posts__paginated", defaults={"page" = 1})
     * @Template()
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPostsAction($page = 1)
    {
        $em = $this->getDoctrine()->getManager();

        // gestion de la pagination
        $adapter = new DoctrineORMAdapter($em->getRepository(Post::class)->findAllPostsDescending());
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(3);
        $pager->setCurrentPage($page);

        return $this->render('listPosts.html.twig', array(
            'pager' => $pager
        ));
    }
}
