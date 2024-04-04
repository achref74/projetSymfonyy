<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType; // Import VichFileType

class ClientAdditionalInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('imageProfil', VichFileType::class, [
            'label' => 'Image de profil',
            'mapped' => false, // Indique à Symfony de ne pas mapper ce champ à une propriété de l'entité
            'required' => false, // Rend le champ facultatif
        ])     
               ->add('genre')
            ->add('niveauScolaire')
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
