<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\EntityType;
use App\DataFixtures\CategoryFixtures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;

class SearchProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('search', SearchType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Titre de l\'emploi ou mot-clé',
                ],
            ])
            ->add('location', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Localisation',
                ],
            ])
            ->add('category', ChoiceType::class, [
                'required' => false,
                'choices' => $options['categories'],
                'choice_label' => function ($category) {
                    return $category->getName();
                },
                'placeholder' => 'Catégorie',
                'label' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'categories' => null, // Définissez la valeur par défaut appropriée si nécessaire
        ]);
    }
}
