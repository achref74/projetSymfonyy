<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Form\DataTransformer\ChoixToCrxTransformer; 
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class QuestionType extends AbstractType
{
    private $transformer;

    public function __construct(ChoixToCrxTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

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
                'constraints' => [
                    new GreaterThan([
                        'value' => 0,
                        'message' => 'La durée doit être supérieure à 0.',
                    ]),
                    new NotBlank([
                        'message' => 'La durée est requise.',
                    ]),
                ],
            ])
            ->add('point', IntegerType::class, [
                'label' => 'Point',
                'attr' => ['class' => 'rounded col-5'],
                'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],
                'constraints' => [
                    new Range([
                        'min' => 1,
                        'max' => 20,
                        'notInRangeMessage' => 'Le point doit être entre {{ min }} et {{ max }}.',
                        
                    ]),
                ],
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
            // ->add('reponse', TextType::class, [
            //     'label' => 'Réponse',
            //     'attr' => ['class' => 'rounded col-5'],
            //     'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],
            //     'required' => false,
            // ])
            ->add('crx', ChoiceType::class, [
                'label' => 'CRX',
                'attr' => ['class' => 'rounded col-5'],
                'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],
                'choices' => [
                    'Choix 1' => '1',
                    'Choix 2' => '2',
                    'Choix 3' => '3',
                ],
            ]);
    
            $builder->get('choix1')->addModelTransformer($this->transformer);
            $builder->get('choix2')->addModelTransformer($this->transformer);
            $builder->get('choix3')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'label' => false,
        ]);
    }
}
