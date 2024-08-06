<?php

namespace App\Form;

use App\Entity\Candidate;
use App\Entity\Stage;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class CandidateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'First Name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'name' => 'candidate[firstName]',
                    'id' => 'candidate_first_name',
                ],
                'constraints' => [
                    new NotBlank(null, 'First name cannot be empty.')
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Last Name',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'name' => 'candidate[lastName]',
                    'id' => 'candidate_last_name',
                ],
                'constraints' => [
                    new NotBlank(null, 'Last name cannot be empty.')
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'name' => 'candidate[email]',
                    'id' => 'candidate_email',
                ],
                'constraints' => [
                    new NotBlank(null, 'Email cannot be empty.')
                ],
            ])
            ->add('skills', TextType::class, [
                'label' => 'Skills',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'name' => 'candidate[skills]',
                    'id' => 'candidate_skills',
                ],
                'constraints' => [
                    new NotBlank(null, 'Skills cannot be empty.')
                ],
            ])
            ->add('cv', FileType::class, [
                'label' => 'CV (PDF file)',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'name' => 'candidate[cv]',
                    'id' => 'candidate_cv',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid PDF document',
                    ])
                ]
            ])
            ->add('stage', EntityType::class, [
                'class' => Stage::class,
                'choice_label' => 'type',
                'label' => 'Stage',
                'placeholder' => 'Choose the Stage...',
                'attr' => [
                    'class' => 'form-select',
                    'name' => 'candidate[stage]',
                    'id' => 'candidate_stage',
                ],
                'constraints' => [
                    new NotBlank(null, 'You must select a stage.')
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidate::class,
            'attr' => [
                'id' => 'candidate-form',
                'enctype' => 'multipart/form-data'
            ],
            'method' => 'POST',
            'allow_extra_fields' => true
        ]);
    }
}
