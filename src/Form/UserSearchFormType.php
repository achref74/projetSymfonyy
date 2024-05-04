<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSearchFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('authCode')
            ->add('dateNaissance')
            ->add('adresse')
            ->add('numtel')
            ->add('imageProfil')
            ->add('genre')
            ->add('mdp')
            ->add('role')
            ->add('activated')
            ->add('specialite')
            ->add('niveauAcademique')
            ->add('disponiblite')
            ->add('cv')
            ->add('niveau_scolaire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
