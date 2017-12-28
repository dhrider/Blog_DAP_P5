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
               'label' => 'Title',
               'attr' => array(
                   'placeholder' => 'Enter a title'
               )
           ))
           ->add('chapo', TextareaType::class, array(
               'label' => 'Summary',
               'attr' => array(
                   'placeholder' => 'Enter a summary',
                   'style' => 'height: 100px; resize: vertical'
               )
           ))
           ->add('content', TextareaType::class, array(
               'label' => 'Content',
               'attr' => array(
                   'placeholder' => 'Enter the content',
                   'style' => 'height: 300px; resize: vertical'
               )
           ))
           ->add('author', TextType::class, array(
               'label' => 'Author',
               'attr' => array(
                   'placeholder' => 'Enter your Name'
               )
           ))
           ->add('captcha', CaptchaType::class, array(
               'label' => 'Captcha',
               'reload' => true,
               'as_url' => true,
               'attr' => array(
                   'placeholder' => 'Enter the captcha as above'
               )
           ))
           ->add('Submit', SubmitType::class, array(
               'attr' => array(
                   'class' => 'btn-primary pull-left'
               ),
               'label' => 'Validate'
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
