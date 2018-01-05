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

            $session = $this->container->get('session');
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

                $session = $this->container->get('session');
                $session->getFlashBag()->set('success', 'Your username has been successfully send to your email.');
            }
            else
            {
                $session = $this->container->get('session');
                $session->getFlashBag()->set('warning', 'This email doesn\'t exist.');
            }
        }

        return $this->render(':User:recoveryUsernameUser.html.twig');
    }

    public function recoveryPasswordUserAction(Request $request)
    {

    }
}
