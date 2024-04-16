<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType; // Add this line
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'required' => true,
                'label' => 'Nom:',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'required' => true,
                'label' => 'Description:',
                'attr' => ['class' => 'form-control', 'rows' => 3]
            ])
            ->add('prix', NumberType::class, [
                'required' => true,
                'label' => 'Prix:',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dated', DateType::class, [
                'required' => true,
                'label' => 'Date de début:',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('datef', DateType::class, [
                'required' => true,
                'label' => 'Date de fin:',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
            ])
            ->add('nbrcours', NumberType::class, [
                'required' => true,
                'label' => 'Nombre de cours:',
                'attr' => ['class' => 'form-control']
            ])
            ->add('imageUrl', FileType::class, [
                'required' => false,
                'label' => 'Image File:',
                'attr' => ['class' => 'form-control-file']
            ])
         ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Adjust this to match your entity class
            'data_class' => Formation::class,
        ]);
    }
}