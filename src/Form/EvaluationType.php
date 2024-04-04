<?php

namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Cours;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            ->add('questions', CollectionType::class, [
                'entry_type' => QuestionType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'prototype' => true,
                'prototype_name' => '__question_prototype__',
                'attr' => [
                    'class' => 'question-collection',
                ],
            ])
            ->add('save', SubmitType::class, ['label' => 'Save Evaluation'])
            ->setAction($options['action'] ?? '')
            ->setMethod('POST');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
        ]);
    }
}
