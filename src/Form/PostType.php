<?php

namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('title')
                ->add('content')
                ->add('slug')
                ->add('id')
                ->add('published')
                ->add('createdAt')
                ->add('updatedAt')
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form-control',
//              Use custom template if needed
//                'template' => 'admin/forms/page_form.html.twig'
            ],
            'data_class' => Post::class,
        ]);
    }
}
