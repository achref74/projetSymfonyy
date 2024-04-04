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
            ->add('video', FileType::class, [
                'label' => 'Video',
                'mapped' => false, // Tells Symfony not to try to set the 'video' field on your entity/entity form object
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please upload a video',
                    ]),
                    new File([
                        'maxSize' => '1024M', // Adjust the max size as needed, 'M' stands for Megabytes
                        'mimeTypes' => [
                            'video/mp4',
                            'video/mpeg',
                            'video/quicktime',
                            'video/x-ms-wmv',
                            'video/x-flv',
                            'video/webm',
                            'video/x-msvideo',
                            'video/3gpp',
                            'video/x-matroska',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid video',
                    ]),
                ],
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