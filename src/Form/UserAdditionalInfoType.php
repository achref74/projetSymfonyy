<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;



class UserAdditionalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageProfil', FileType::class, [
            'label' => 'Image de profil',
            'mapped' => false,
            'required' => false,
        ])
        ->add('genre', ChoiceType::class, [
            'choices' => [
                'Homme' => 'Homme',
                'Femme' => 'Femme',
                'Autre' => 'Autre',
            ],
            'label' => 'Genre',
            'required' => true,
        ])
        ->add('specialite')
        ->add('niveauAcademique', ChoiceType::class, [
            'choices' => [
                'Primaire' => 'primaire',
                'Secondaire' => 'secondaire',
                'Universitaire' => 'universitaire',
            ],
            'label' => 'Niveau Académique',
            'required' => true,
        ])
        ->add('disponiblite')
        ->add('cv', FileType::class, [
            'label' => 'CV',
            'mapped' => false,
            'required' => false,
        ])
        ->add('mdp', PasswordType::class, [
            'label' => 'Mot de passe',
            'required' => true,
            'attr' => [
                'autocomplete' => 'new-password',
            ],
        ])
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
