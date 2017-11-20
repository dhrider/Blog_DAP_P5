<?php
// src/Form/ContactType.php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label_attr' => array(
                    'class' => 'texteEnBlanc'
                ),
                'attr' => array(
                    'placeholder' => 'Your First Name'
                )
            ))
            ->add('name',TextType::class, array(
                'label_attr' => array(
                    'class' => 'texteEnBlanc'
                ),
                'attr' => array(
                    'placeholder' => 'Your Name'
                )
            ))
            ->add('email', RepeatedType::class, array(
                'type' => EmailType::class,
                'invalid_message' => 'The emails are not the same !',
                'first_options' => array(
                    'label' => 'Enter Email',
                    'label_attr' => array(
                        'class' => 'texteEnBlanc'
                    ),
                    'attr' => array(
                        'placeholder' => 'Your email'
                    )
                ),
                'second_options' => array(
                    'label' => 'Repeat Email',
                    'label_attr' => array(
                        'class' => 'texteEnBlanc'
                    ),
                    'attr' => array(
                        'placeholder' => 'Repeat you email'
                    )
                )
            ))
            ->add('message', TextareaType::class, array(
                'label' => 'Message',
                'label_attr' => array(
                    'class' => 'texteEnBlanc'
                ),
                'attr' => array(
                    'placeholder' => 'Your Message',
                    'style' => 'height: 100px',
                    'class' => 'contactTextArea'
                )
            ))
            ->add('captcha', CaptchaType::class, array(
                'label' => false,
                'reload' => true,
                'as_url' => true
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary pull-left'
                ),
                'label' => false
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Contact'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'contact';
    }
}
