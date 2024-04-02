<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom')
        ->add('prenom')
        ->add('email')
        ->add('dateNaissance')
        ->add('adresse')
        ->add('numtel')
        ->add('role', ChoiceType::class, [
            'choices' => [
                'Client' => 0,
                'Formateur' => 1,
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'Vous êtes',
        ])
        
        ->add('suivant', SubmitType::class, [
            'label' => 'Suivant',
        ]);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
