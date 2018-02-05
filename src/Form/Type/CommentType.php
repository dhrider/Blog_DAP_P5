<?php

namespace App\Form\Type;

use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Name'
                )
            ))
            ->add('content', TextareaType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Your Comment',
                    'style' => 'height: 75px'
                )
            ))
            ->add('captcha', CaptchaType::class, array(
                'label' => false,
                'reload' => true,
                'as_url' => true,
                'attr' => array(
                    'placeholder' => 'Enter the captcha as above'
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
            'data_class' => 'App\Entity\Comment'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'comment';
    }
}
