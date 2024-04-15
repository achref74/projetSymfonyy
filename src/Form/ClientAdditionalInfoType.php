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
class ClientAdditionalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('image', FileType::class, [
            'label' => 'Image',
            'mapped' => false, // Indique à Symfony de ne pas mapper ce champ à une propriété de l'entité
            'required' => false, // Rend le champ facultatif
        ])     
        ->add('genre', ChoiceType::class, [
            'choices' => [
                'Homme' => 'Homme',
                'Femme' => 'Femme',
                'Autre' => 'Autre',
            ],
            'label' => 'Genre',
            'required' => true,
        ])               ->add('niveauScolaire', ChoiceType::class, [
                'choices' => [
                    'Primaire' => 'primaire',
                    'Secondaire' => 'secondaire',
                    'Universitaire' => 'universitaire',
                ],
                'label' => 'Niveau Scolaire',
                'required' => true,
            ])
            ->add('mdp', PasswordType::class, [
                'label' => 'Mot de passe',
                'required' => true,
                'attr' => [
                    'autocomplete' => 'new-password', // For modern browsers to understand it's a new password field
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
