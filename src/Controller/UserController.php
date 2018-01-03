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

            return $this->redirectToRoute('login');
        }

        return $this->render(':User:registerUser.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
