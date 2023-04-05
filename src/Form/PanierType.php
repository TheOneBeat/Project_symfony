<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class PanierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',
                TextType::class,
                [
                    'label'=>'nom du produit',
                    'attr'=>['placeholder'=> 'wording'],
                    'constraints' => [
                        new NotBlank(),
                    ],
                ])

            ->add('prix',
                NumberType::class,
                [
                    'label'=>"the price of the item",
                    'attr'=>['placeholder'=>"price"],
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
                    ],
                ])

            ->add('quantity', ChoiceType::class, [
                'label' => 'Choice :',
                'choices' => array_combine(range(0, $options['product']->getEnstock()), range(0, $options['product']->getEnstock())),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
