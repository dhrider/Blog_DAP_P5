<?php

namespace App\Form\Type;

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
               'label' => false,
               'attr' => array(
                   'placeholder' => 'Enter a title'
               )
           ))
           ->add('chapo', TextareaType::class, array(
               'label' => false,
               'attr' => array(
                   'placeholder' => 'Enter a summary',
                   'style' => 'height: 100px; resize: vertical'
               )
           ))
           ->add('content', TextareaType::class, array(
               'label' => false,
               'attr' => array(
                   'placeholder' => 'Enter the content',
                   'style' => 'height: 300px; resize: vertical'
               )
           ))
           ->add('author', TextType::class, array(
               'label' => false,
               'attr' => array(
                   'placeholder' => 'Enter your Name'
               )
           ))
           ->add('Submit', SubmitType::class, array(
               'attr' => array(
                   'class' => 'btn-primary pull-left'
               ),
               'label' => 'Save'
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
