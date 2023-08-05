<?php

namespace App\Form;

use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titleProfil', TextType::class, [
                'label' => 'Votre nom',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('descriptionProfil', TextType::class, [
                'label' => 'Votre profil',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('locationProfil', TextType::class, [
                'label' => 'Votre localisation',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('experienceYear', IntegerType::class, [
                'label' => "Vos années d'expériences",
                'attr' => ['class' => 'form-control'],
            ])
            ->add('skills', TextType::class, [
                'label' => 'Vos compétences',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('education', TextType::class, [
                'label' => 'Votre niveau d\'étude',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('language', TextType::class, [
                'label' => 'Langues parlées',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('birthDay', DateType::class, [
                'label' => 'Votre date de naissance',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('mobility', IntegerType::class, [
                'label' => "Votre zone géographique (km)",
                'attr' => ['class' => 'form-control'],
            ])
            ->add('posterFile', VichFileType::class, [
                'label'      => 'Déposer votre image',
                'required'      => true,
                'allow_delete'  => false,
                'download_uri' => false,
                ])

                ->add('documentFile', VichFileType::class, [
                    'label'      => 'Déposer votre CV ( Format PDF )',
                    'mapped'      => true,
                    'constraints' => [
                         new File([
                             'mimeTypesMessage' => 'Veuillez télécharger un document PDF valide',
                         ])
                    ],
                    'allow_delete'  => false,
                    'download_uri' => false,
                ])
                ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
