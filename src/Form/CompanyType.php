<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de votre entreprise ",
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('description', TextType::class, [
                'label' => "Décrivez votre entreprise",
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('location', TextType::class, [
                'label' => "Indiquez votre localisation",
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('posterFile', VichFileType::class, [
                'required'      => true,
                'allow_delete'  => false,
                'download_uri' => false,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
