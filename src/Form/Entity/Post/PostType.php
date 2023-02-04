<?php

namespace App\Form\Entity\Post;

use App\Entity\Post;
use App\Form\CKEditorType;
use App\Form\DataTransformer\JsonTransformer;
use App\Form\TagsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content', CKEditorType::class, ['label' => false, 'required' => false,])
            ->add('author')
            ->add('published', CheckboxType::class, ['required' => false])
            ->add('tags', TagsType::class, ['required' => false])
//                ->add('createdAt')
//                ->add('updatedAt')
        ;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form-control',
//              Use custom template if needed
                'template' => 'admin/forms/page_form.html.twig'
            ],
            'data_class' => Post::class,
        ]);
    }
}
