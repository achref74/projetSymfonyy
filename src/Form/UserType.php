<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\LessThan;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'required' => false, // Set the required attribute to false
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom ne doit pas être vide.',
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le nom ne doit contenir que des lettres.',
                ]),
            ],
        ])
        ->add('prenom', TextType::class, [
            'required' => false, // Set the required attribute to false
            'constraints' => [
                new NotBlank([
                    'message' => 'Le prenom ne doit pas être vide.',
                ]),
                new Regex([
                    'pattern' => '/^[a-zA-Z]+$/',
                    'message' => 'Le prénom ne doit contenir que des lettres.',
                ]),
            ],
        ])
        ->add('email', EmailType::class, [
            'required' => false, // Set the required attribute to false
            'constraints' => [
                new NotBlank([
                    'message' => 'L`email ne doit pas être vide.',
                ]),                
                new Email([
                    'message' => 'Veuillez saisir une adresse email valide.',
                ]),
            ],
        ])
          ->add('dateNaissance', DateType::class, [
            'required' => false, // Set the required attribute to false
            'widget' => 'single_text',
            'html5' => false, // Set to false to use a custom date format
            'format' => 'yyyy-MM-dd', // Specify the desired date format
            'years' => range(date('Y') - 100, date('Y') - 18), // Adjust the date range
            'constraints' => [
                new LessThan([
                    'value' => '2004-01-01',
                    'message' => 'La date de naissance doit être inférieure à 2004-01-01.'
                ]),]
        ])
        ->add('adresse', TextType::class, [
            'required' => false, // Set the required attribute to false
            'constraints' => [
                new NotBlank([
                    'message' => 'L`adresse ne doit pas être vide.',
                ]),
            ],
        ])
        ->add('numtel', IntegerType::class, [
            'required' => false, // Set the required attribute to false
            'constraints' => [
                new NotBlank([
                    'message' => 'Le numéro de téléphone ne doit pas être vide.',
                ]),
                new Length([
                    'min' => 8,
                    'max' => 8,
                    'exactMessage' => 'Le numéro de téléphone doit contenir exactement 8 chiffres.',
                ]),
            ],
        ])
        ->add('role', ChoiceType::class, [
            'choices' => [
                'Client' => 0,
                'Formateur' => 1,
            ],
            'expanded' => true,
            'multiple' => false,
            'label' => 'Vous êtes',
            'constraints' => [
                new NotBlank(),
            ],
        ])
        ->add('suivant', SubmitType::class, [
            'label' => 'Suivant',
        ]);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
