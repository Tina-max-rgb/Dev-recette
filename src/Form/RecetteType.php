<?php

namespace App\Form;
use App\Entity\Recette;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class RecetteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('name', TextType::class, [
            'attr' => [
                'class' => 'form-control',
                'minlength' => 2,
                'maxlength' => 50,
            ],
            'label' => 'name',
            'label_attr' => [
                'class' => 'form-label mt-4',
            ],

            'constraints' => [
                new Assert\Length(['min' => 2, 'max' => 50]),
                new Assert\NotBlank(),
            ],
        ])
        ->add('prix', MoneyType::class, [
            'attr' => [
                'class' => 'form-control',                
            ],
            'label' => 'prix', // Correction de l'intitulé du champ
            'label_attr' => [
                'class' => 'form-label mt-4',
            ],
            'constraints' => [
                new Assert\Positive(),
                new Assert\LessThan(1001),
            ],
        ])
            
            ->add('time', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 1,
                    'maxlength' => 1440,
                    
                ],
                'label' => 'time', // Correction de l'intitulé du champ
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\LessThan(1440),
                ],
            ])
                ->add('Nbpersonne', IntegerType::class, [
                    'attr' => [
                        'class' => 'form-control',
                        'minlength' => 1,
                    'maxlength' => 50,
                        
                    ],
                    'label' => 'Nbpersonne', // Correction de l'intitulé du champ
                    'label_attr' => [
                        'class' => 'form-label mt-4',
                    ],
                    'constraints' => [
                        new Assert\Positive(),
                        new Assert\LessThan(51),
                    ],
            
           ])

            ->add('difficulty', RangeType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => 1,
                    'maxlength' => 5,
                    
                ],
                'label' => 'difficulty', // Correction de l'intitulé du champ
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(6),
                ],
            ])
        
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    
                ],
                'label' => 'description', // Correction de l'intitulé du champ
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    
                ],
            ])
         
            ->add('IsFavorite',CheckboxType::class, [
                'attr' => [
                    'class' => 'form-control',    
                ],
                'label' => 'Favorite ?', // Correction de l'intitulé du champ
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotNull(),
                ],
            ])
                
         
            ->add('IngredientsL',  CollectionType::class, [
                'attr' => [
                    'class' => 'form-control',    
                ],
                'label' => 'IngredientsL', // Correction de l'intitulé du champ
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ])
           
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary form-label mt-4',
                    'minlength' => 2,
                'maxlength' => 50,
            ],
        ]);
                       
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recette::class,
        ]);
    }

}