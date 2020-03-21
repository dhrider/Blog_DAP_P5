<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class UserController extends Controller
{
    public function manageUsersAction($page, UserRepository $userRepository)
    {
        $adapter = new DoctrineORMAdapter($userRepository->findAllUser(), false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($page);

        return $this->render('Admin/User/manageUser.html.twig', array(
            'pager' => $pager
        ));
    }

    public function deleteUserAction(User $user, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $userToDelete = $userRepository->find($user->getId());

        $entityManager->remove($userToDelete);
        $entityManager->flush();

        return $this->redirectToRoute('manageUsers');
    }

    public function validationUserAction(User $user, EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
    {
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $entityManager->persist($user);
        $entityManager->flush();

        $date = new \DateTime();

        $email = new \Swift_Message;

        $email
            ->setSubject('Philippe Bordmann Blog User validation')
            ->setFrom('p_bordmann@orange.fr')
            ->setTo($user->getEmail())
            ->setContentType('text/html')
            ->setBody($this->render('User/recoveryUsernameUserEmail.html.twig', array(
                'user' => $user,
                'date' => $date
            )))
        ;

        $mailer->send($email);

        return $this->redirectToRoute('manageUsers');
    }
}
