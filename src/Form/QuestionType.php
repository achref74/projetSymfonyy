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
        ->add('ressource', TextType::class, [
            'label' => 'Ressource',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],

        ])
        ->add('duree', IntegerType::class, [
            'label' => 'Durée',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],

        ])
        ->add('point', IntegerType::class, [
            'label' => 'Point',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],

        ])
        ->add('choix1', TextType::class, [
            'label' => 'Choix 1',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],

        ])
        ->add('choix2', TextType::class, [
            'label' => 'Choix 2',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],

        ])
        ->add('choix3', TextType::class, [
            'label' => 'Choix 3',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],

        ])
        ->add('reponse', TextType::class, [
            'label' => 'Réponse',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],
            'required' => false,

        ])
        ->add('crx', TextType::class, [
            'label' => 'CRX',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],

        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'label' => false,
        ]);
    }
}
