<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('title', TextType::class, array(
               'attr' => array(
                   'placeholder' => 'Entrez un titre'
               )
           ))
           ->add('chapo', TextareaType::class, array(
               'attr' => array(
                   'placeholder' => 'Ecrivrez votre introduction'
               )
           ))
           ->add('content', TextareaType::class, array(
               'attr' => array(
                   'placeholder' => 'Ecrivez votre post'
               )
           ))
           ->add('author', TextType::class, array(
               'attr' => array(
                   'placeholder' => 'Ecrivez votre nom'
               )
           ))
           ->add('captcha', CaptchaType::class, array(
               'reload' => true,
               'as_url' => true,
               'attr' => array(
                   'placeholder' => 'Ecrivez le captcha ci-dessus'
               )
           ))
           ->add('Submit',         SubmitType::class, array(
               'attr' => array(
                   'class' => 'btn-primary pull-left'
               ),
               'label' => 'Valider'
           ))
       ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Post'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'post';
    }
}
