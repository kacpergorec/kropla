<?php

namespace App\Form\Entity\User;

use App\Entity\User;
use App\Form\DataTransformer\JsonTransformer;
use App\Form\RoleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('email')
            ->add('roles', RoleType::class);

        $builder->get('roles')
            ->addModelTransformer(new JsonTransformer());

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => ['class' => 'form-control'],
            'data_class' => User::class,
        ]);
    }
}
