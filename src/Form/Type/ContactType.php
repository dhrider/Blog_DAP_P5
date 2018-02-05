<?php

namespace App\Form\Type;

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
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your First Name'
                )
            ))
            ->add('lastName',TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your Last Name'
                )
            ))
            ->add('email', RepeatedType::class, array(
                'type' => EmailType::class,
                'invalid_message' => 'The emails are not the same !',
                'first_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Your email'
                    )
                ),
                'second_options' => array(
                    'label' => false,
                    'attr' => array(
                        'placeholder' => 'Repeat you email'
                    )
                )
            ))
            ->add('message', TextareaType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your Message',
                    'style' => 'height: 100px'
                )
            ))
            ->add('captcha', CaptchaType::class, array(
                'label' => false,
                'reload' => true,
                'as_url' => true,
                'attr' => array(
                    'placeholder' => 'Enter the same text as above'
                )
            ))
            ->add('submit', SubmitType::class, array(
                'attr' => array(
                    'class' => 'btn-primary pull-left'
                ),
                'label' => 'Send'
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
