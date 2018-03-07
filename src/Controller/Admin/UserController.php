<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;

class UserController extends Controller
{
    public function manageUsersAction($page)
    {
        $em = $this->getDoctrine()->getManager();

        $adapter = new DoctrineORMAdapter($em->getRepository(User::class)->findAllUser(), false);
        $pager = new Pagerfanta($adapter);
        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($page);

        return $this->render('Admin/User/manageUser.html.twig', array(
            'pager' => $pager
        ));
    }

    public function deleteUserAction(User $user)
    {
        $em = $this->getDoctrine()->getManager();

        $userToDelete = $em->getRepository(User::class)->find($user->getId());

        $em->remove($userToDelete);
        $em->flush();

        return $this->redirectToRoute('manageUsers');
    }

    public function validationUserAction(User $user, \Swift_Mailer $mailer)
    {
        $em = $this->getDoctrine()->getManager();

        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

        $em->persist($user);
        $em->flush();

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
