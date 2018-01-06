<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function registerUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $session = $this->container->get('session');

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $hash = $this
                ->get('security.encoder_factory')
                ->getEncoder($user)
                ->encodePassword($form->getData()->getPassword(), $user->getSalt())
            ;

            $user->setUsername($form->getData()->getUsername());
            $user->setEmail($form->getData()->getEmail());
            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);

            $em->persist($user);
            $em->flush();

            $success = true;

            $session
                ->getFlashBag()
                ->set('success', 'You\'ve been successfully registred. 
                You can now login with your username & password.')
            ;

            return $this->redirectToRoute('login', array(
                'success' => $success
            ));
        }

        return $this->render(':User:registerUser.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function recoveryUsernameUserAction(Request $request, \Swift_Mailer $mailer)
    {
        if ($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(User::class)->findByEmail($request->request->get('email'));

            $session = $this->container->get('session');

            if ($user)
            {
                $date = new \DateTime();

                $email = new \Swift_Message;

                $email
                    ->setSubject('Philippe Bordmann Blog Message')
                    ->setFrom('p_bordmann@orange.fr')
                    ->setTo($user->getEmail())
                    ->setContentType('text/html')
                    ->setBody($this->render(':User:recoveryUsernameUserEmail.html.twig', array(
                        'user' => $user,
                        'date' => $date
                    )))
                ;

                $mailer->send($email);

                $session->getFlashBag()->set('success', 'Your username has been successfully send to your email.');
            }
            else
            {
                $session->getFlashBag()->set('warning', 'This email doesn\'t exist.');
            }
        }

        return $this->render(':User:recoveryUsernameUser.html.twig');
    }

    public function resetPasswordUserAction(Request $request, \Swift_Mailer $mailer)
    {
        if ($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();

            $user = $em->getRepository(User::class)->findByEmail($request->request->get('email'));

            $session = $this->container->get('session');

            if ($user)
            {
                $user->setToken(hash("sha512", uniqid()));

                $em->persist($user);
                $em->flush();

                $email = new \Swift_Message;

                $email
                    ->setSubject('Philippe Bordmann Blog Message')
                    ->setFrom('p_bordmann@orange.fr')
                    ->setTo($user->getEmail())
                    ->setContentType('text/html')
                    ->setBody($this->render(':User:resetPasswordUserEmail.html.twig', array(
                        'date' => new \DateTime(),
                        'token' => $user->getToken()
                    )))
                ;

                $mailer->send($email);

                $session->getFlashBag()->set('success', 'A link for resetting your password has been send to your email.');
            }
            else
            {
                $session = $this->container->get('session');
                $session->getFlashBag()->set('warning', 'This email doesn\'t exist.');
            }
        }

        return $this->render(':User:resetPasswordUser.html.twig');
    }

    public function newPasswordUserAction(User $user, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $userExist = $em->getRepository(User::class)->findOneBy(array("token" => $user->getToken()));

        $session = $this->container->get('session');

        if ($request->isMethod('POST'))
        {
            if ($request->request->get('password1') !== $request->request->get('password2'))
            {
                $session->getFlashBag()->set('warning', 'The password are not the same.');

                return $this->redirectToRoute('new_password_user', array(
                    'token' => $user->getToken()
                ));
            }
            else
            {
                $hash = $this
                    ->get('security.encoder_factory')
                    ->getEncoder($user)
                    ->encodePassword($request->request->get('password1'), $user->getSalt())
                ;

                $user->setPassword($hash);

                $em->persist($user);
                $em->flush();

                $success = true;
                $session->getFlashBag()->set('success', 'Your new password is now valid.');

                return $this->redirectToRoute('login', array(
                    'success' => $success
                ));
            }
        }

        if ($userExist)
        {
            return $this->render(':User:newPasswordUser.html.twig');
        }
        else
        {
            $session->getFlashBag()->set('warning', 'The link for resetting your password is not valid.');

            return $this->redirectToRoute('login');
        }
    }
}
