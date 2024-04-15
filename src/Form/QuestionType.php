<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ressource', TextType::class)
            ->add('duree', IntegerType::class)
            ->add('point', IntegerType::class)
            ->add('choix1', TextType::class)
            ->add('choix2', TextType::class)
            ->add('choix3', TextType::class)
            ->add('reponse', TextType::class, [
                'required' => false,
            ])
            ->add('crx', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'label' => false,
        ]);
    }
}
