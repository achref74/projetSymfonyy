<?php

namespace App\Form;

use App\Entity\Offre;

use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('prixOffre', null, ['required' => false])
        ->add('description', null, ['required' => false])
        ->add('dateD', null, ['required' => false])
        ->add('dateF', null, ['required' => false])
            // ->add('formation', EntityType::class, [
            //     'class' => Formation::class,
            //     'choice_label' => 'nom', // Assuming 'name' is the property of Formation entity to display in the dropdown
            //     // You can add more options here as needed
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
