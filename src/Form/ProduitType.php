<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',
                TextType::class,
                [
                    'label'=>'nom du produit',
                    'attr'=>['placeholder'=> 'libelle'],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])

            ->add('prix',
                NumberType::class,
                [
                    'label'=>"le prix de l'article",
                    'attr'=>['placeholder'=>"prix"],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])

            ->add('enstock',
                IntegerType::class,
                [
                    'label'=>"nombre de stock",
                    'attr'=>['placeholder'=>"stock"],
                    'constraints' => [
                        new NotBlank(),
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
