<?php

namespace App\Form\Entity\Page;

use App\Entity\Category;
use App\Entity\Page;
use App\Form\CKEditorType;
use App\Form\DataTransformer\JsonTransformer;
use App\Form\TagsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => false])
            ->add('content', CKEditorType::class, ['label' => false, 'required' => false,])
            ->add('redirectUrl', UrlType::class, ['required' => false])
            ->add('promoted', CheckboxType::class, ['required' => false])
            ->add('published', CheckboxType::class, ['required' => false])
            ->add('tags', TagsType::class, ['required' => false])
            ->add('category', EntityType::class, ['class'=> Category::class,'placeholder' => 'Bez kategorii', 'required' => false])
            ->add('author');

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'form-control',
                'template' => 'admin/forms/page_form.html.twig'
            ],
            'data_class' => Page::class,
        ]);
    }
}
