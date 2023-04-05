<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',
                TextType::class,
                [
                    'label'=>'Product Name',
                    'attr'=>['placeholder'=> 'libelle'],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])

            ->add('prix',
                NumberType::class,
                [
                    'label'=>"the price of the item",
                    'attr'=>['placeholder'=>"prix"],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])

            ->add('enstock',
                IntegerType::class,
                [
                    'label'=>"stock number",
                    'attr'=>['placeholder'=>"stock"],
                    'constraints' => [
                        new NotBlank(),
                        new Callback([
                            'callback' => function ($enstock, ExecutionContextInterface $context) {
                                if ($enstock < 0) {
                                    $context->buildViolation('Le nombre de stock doit être supérieur à 0')
                                        ->atPath('enstock')
                                        ->addViolation();
                                }
                            },
                        ]),
                    ],

                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
