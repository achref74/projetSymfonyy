<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\User;

use App\Entity\Reponse;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReponseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('user', EntityType::class, [
            'class' => User::class,
            'choice_label' => 'idUser',
        ])
            ->add('description')
            ->add('dateReponse')
            ->add('reclamation', EntityType::class, [
                'class' => Reclamation::class,
                'choice_label' => 'description',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reponse::class,
        ]);
    }
}
