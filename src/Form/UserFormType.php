<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('login')
            ->add('password', PasswordType::class)
            ->add('roles', ChoiceType::class, [ 
                'choices' => [ 
                    'Admin' => 'ROLE_ADMIN', 
                    'Boutiquier' => 'ROLE_BOUTIQUIER', 
                    'client' => 'ROLE_CLIENT', 
                ], 
                'multiple' => true, 
                'expanded' => true, // Utilise des checkboxes 
            ])
            ->add('Enregistrer', SubmitType::class, [
                'label'=> 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
