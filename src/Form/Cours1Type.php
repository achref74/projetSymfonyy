<?php

namespace App\Form;

use App\Entity\Cours;
use App\Form\DataTransformer\StringToFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;



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
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datepicker',
                ],
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
            ->add('image', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'height: auto;', // Optional: Adjust the height
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid JPG or PNG image',
                    ])
                ],
            ]);

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}