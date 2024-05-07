<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('contenup', TextareaType::class, [
            'label' => 'Contenu',
            'attr' => ['class' => 'form-control', 'id' => 'exampleContenu', 'rows' => '6'],
            'constraints' => [
                new NotBlank(['message' => 'Le contenu ne peut pas être vide.']),
                new Regex([
                    'pattern' => '/^[a-zA-Z\s]*$/',
                    'message' => 'Le contenu ne peut contenir que des lettres et des espaces.',
                ]),
            ],
        ])

            ->add('image', FileType::class, [
                'label' => 'Choisir une image',
                'required' => false, // Rendre le champ facultatif
                'mapped' => false, // Ne pas mapper ce champ sur l'entité
            ])
            ->add('nblike')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
