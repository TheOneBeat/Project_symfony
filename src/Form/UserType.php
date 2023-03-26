<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',
            TextType::class,
            [
                'label'=>'your Name',
                'attr'=>['placeholder'=>'name'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 4, 'max' => 255]),
                ],
            ])
            ->add('first_name',
            TextType::class,
            [
                'label'=>'your FirstName',
                'attr'=>['placeholder'=>'firstName'],
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 4, 'max' => 255]),
                ],
            ])

            ->add('login',
                TextType::class,
                [
                    'label'=>'your Login',
                    'attr'=>['placeholder'=>'login'],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])

            ->add('Birth_day',
                BirthdayType::class,
                [
                    'placeholder' => [
                        'year' => 'Year', 'month' => 'Month', 'day' => 'Day',
                    ],
                ])

            ->add('password',
                PasswordType::class,
                [
                    'label'=>'your Password',
                    'attr'=>['placeholder'=>'password'],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
