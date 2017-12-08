<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                   'placeholder' => 'Entrez un titre'
               )
           ))
           ->add('chapo', TextareaType::class, array(
               'label' => false,
               'attr' => array(
                   'placeholder' => 'Ecrivrez votre introduction'
               )
           ))
           ->add('content', TextareaType::class, array(
               'label' => false,
               'attr' => array(
                   'placeholder' => 'Ecrivez votre post'
               )
           ))
           ->add('author', TextType::class, array(
               'label' => false,
               'attr' => array(
                   'placeholder' => 'Ecrivez votre nom'
               )
           ))
           ->add('Submit',         SubmitType::class, array(
               'attr' => array(
                   'class' => 'btn-primary'
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
