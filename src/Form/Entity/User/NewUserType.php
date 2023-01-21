<?php

namespace App\Form\Entity\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->setAction('new')
            ->add('submit', SubmitType::class, [
                'label' => 'Dodaj nowego'
            ])
            ->add('firstName', TextType::class, [
                'attr' => ['placeholder' => 'Imię']
            ])
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'Adres e-mail']
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['placeholder' => 'Hasło']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
