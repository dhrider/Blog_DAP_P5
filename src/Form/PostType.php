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
               'label' => 'Titre',
               'attr' => array(
                   'placeholder' => 'Entrez un titre'
               )
           ))
           ->add('chapo', TextareaType::class, array(
               'label' => 'Résumé',
               'attr' => array(
                   'placeholder' => 'Ecrivrez votre introduction',
                   'style' => 'height: 100px; resize: vertical'
               )
           ))
           ->add('content', TextareaType::class, array(
               'label' => 'Contenu',
               'attr' => array(
                   'placeholder' => 'Ecrivez votre post',
                   'style' => 'height: 300px; resize: vertical'
               )
           ))
           ->add('author', TextType::class, array(
               'label' => 'Auteur',
               'attr' => array(
                   'placeholder' => 'Ecrivez votre nom'
               )
           ))
           ->add('captcha', CaptchaType::class, array(
               'label' => 'Captcha',
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
