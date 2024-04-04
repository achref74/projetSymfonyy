<?php

namespace App\Form;

use App\Entity\Cours;
use App\Form\DataTransformer\StringToFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class Cours1Type extends AbstractType
{

    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('description', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('date', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('duree', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('prerequis', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('ressource', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('imageProfil', FileType::class, [
                'label' => 'Image de profil',
                'mapped' => false, // Indique à Symfony de ne pas mapper ce champ à une propriété de l'entité
                'required' => false, // Rend le champ facultatif
            ])

        ;

        // Add the data transformer
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}