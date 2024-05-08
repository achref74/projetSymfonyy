<?php
namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Formation;
use App\Entity\Outil;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
class ReclamationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            
            ->add('formation', EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'nom',
            ])
            ->add('outil', EntityType::class, [
                'class' => Outil::class,
                'choice_label' => 'nom',
            ])

            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
