<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserPostCommentFixtures extends Fixture implements  ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $post = new Post();
        $comment = new Comment();

        // création du SUPER_ADMIN
        $hash = $this
            ->container->get('security.encoder_factory')
            ->getEncoder($user)
            ->encodePassword('admin', $user->getSalt())
        ;

        $user->setUsername('admin');
        $user->setEmail('p_bordmann@orange.fr');
        $user->setPassword($hash);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);

        // création d'un post et d'un commentaire rattaché mais non validé
        $post->setTitle('Demo Post');
        $post->setChapo('Creating a demo post');
        $post->setContent('This is the content of the demo post');
        $post->setAuthor('Super Admin');

        $comment->setAuthor('admin');
        $comment->setContent('This is a demo comment');
        $comment->setPost($post);

        // on load la BDD
        $manager->persist($post);
        $manager->persist($comment);
        $manager->persist($user);
        $manager->flush();
    }
}
