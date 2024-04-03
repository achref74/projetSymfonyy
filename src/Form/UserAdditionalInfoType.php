<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class UserAdditionalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageProfil', FileType::class, [
            'label' => 'Image de profil',
            'mapped' => false, // Indique à Symfony de ne pas mapper ce champ à une propriété de l'entité
            'required' => false, // Rend le champ facultatif
        ])
            ->add('genre')
            ->add('specialite')
            ->add('niveauAcademique')
            ->add('disponiblite')
            ->add('cv', FileType::class, [
                'label' => 'cv',
                'mapped' => false, // Indique à Symfony de ne pas mapper ce champ à une propriété de l'entité
                'required' => false, // Rend le champ facultatif
            ])
            ->add('mdp')
            ->add('suivant', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
