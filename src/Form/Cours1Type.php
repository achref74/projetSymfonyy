<?php

namespace App\Form;

use App\Entity\Cours;
use App\Form\DataTransformer\StringToFileTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Doctrine\ORM\EntityManagerInterface;


class Cours1Type extends AbstractType
{

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom',
            'attr' => ['class' => 'rounded col-5'],
            'label_attr' => ['class' => 'col-form-label text-white mx-2 col-2'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Le nom est requis.',
                ]),
                new Callback([
                    'callback' => [$this, 'validateNomUnique'],
                ]),
            ],
        ])
            ->add('description', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datepicker',
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('duree', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('prerequis', null, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('ressource', FileType::class, [
                'label' => 'Ressource (PDF or TXT file)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'accept' => 'application/pdf, text/plain',
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Video (MP4 file)',
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'video/mp4',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid MP4 video',
                    ]),
                ],
                'attr' => [
                    'accept' => 'video/mp4',
                ],
            ]);

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }

    public function validateNomUnique($value, ExecutionContextInterface $context): void
    {
        $existingQuestion = $this->entityManager->getRepository(Cours::class)->findOneBy(['nom' => $value]);

        if ($existingQuestion instanceof Cours) {
            $context->buildViolation('Ce nom existe déjà.')
                ->addViolation();
        }
    }
}