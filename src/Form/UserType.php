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
                'label'=>'Name',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 4, 'max' => 255]),
                ],
            ])
            ->add('first_name',
            TextType::class,
            [
                'label'=>'FirstName',
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 4, 'max' => 255]),
                ],
            ])

            ->add('login',
                TextType::class,
                [
                    'label'=>'Login',
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
                    'label'=>'Password',
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
