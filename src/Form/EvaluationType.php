<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType; // Import the CollectionType
use Symfony\Component\Form\Extension\Core\Type\SubmitType; // Import the SubmitType

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note')
            ->add('nom')
            ->add('cours', EntityType::class, [
                'class' => Cours::class,
                'choice_label' => 'nom',
            ])
            ->add('questions', CollectionType::class, [ // Add the CollectionType for questions
                'entry_type' => QuestionType::class, // Use the QuestionType form for each item
                'entry_options' => ['label' => false], // Hide labels for each question
                'allow_add' => true, // Allow adding new questions
                'by_reference' => false, // Set to false to force calling addQuestion() on the Evaluation entity
                'prototype' => true, // Allow adding a prototype for new questions
                'prototype_name' => '__question_prototype__', // Name of the prototype form
                'attr' => [
                    'class' => 'question-collection', // CSS class for the collection
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Save Evaluation']) // Add a submit button
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
