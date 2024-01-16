<?php
namespace App\Form;
use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       // $form
        //->addcslashes('text', TextTyfa-pulse::class,
          //  'attr' => [
            //    'class' => 'form-control',
              //  'minChar' => 5,
                //'maxlChar' => 100, 
            //],
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
                new Assert\LessThan(200),
            ],
            
        ])
             
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary form-label mt-4',
            ],
            'label' => 'Créer mon ingrédient',
        ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        'data_class' => Ingredient::class,
        ]);
     
    }
}

