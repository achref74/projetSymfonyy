<?php

namespace App\Form;

use App\Entity\Forum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;



class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'exampleInputTitre',
                    'placeholder' => 'Titre',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le titre ne peut pas être vide.']),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Le titre ne peut pas dépasser {{ limit }} caractères.',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'Le titre ne peut contenir que des lettres et des espaces.',
                    ]),
                ],
                
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'class' => 'form-control',
                    'id' => 'exampleTextarea1',
                    'rows' => '4',
                ],
                'constraints' => [
                    new NotBlank(['message' => 'La description ne peut pas être vide.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s]*$/',
                        'message' => 'La description ne peut contenir que des lettres et des espaces.',
                    ]),
                ],
                
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
