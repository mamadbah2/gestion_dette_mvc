<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\DetailDebt;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailDebtFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('article', EntityType::class, [
                'class' => Article::class,
                
                'choice_label' => 'libelle',
            ])
            ->add('quantity', NumberType::class, [
                'label'=> 'Quantité',
                'attr'=> [
                    'min'=> 1,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DetailDebt::class,
        ]);
    }
}
