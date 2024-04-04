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
    private $uploadDirectory;

    public function __construct(string $uploadDirectory)
    {
        $this->uploadDirectory = $uploadDirectory;
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
            ->add('image', null, [
                'constraints' => [
                    new NotBlank(),
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image (jpeg, png, gif)',
                    ]),
                ],
            ])
        ;

        // Add the data transformer
        $builder->get('image')->addModelTransformer(new StringToFileTransformer($this->uploadDirectory));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}