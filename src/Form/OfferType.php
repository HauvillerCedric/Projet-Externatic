<?php

    namespace App\Form;

    use App\Entity\Offer;
    use App\Entity\Category;
    use Symfony\Component\Form\AbstractType;
    use Symfony\Component\Form\FormBuilderInterface;
    use Symfony\Component\OptionsResolver\OptionsResolver;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\IntegerType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Donnez un titre à l'offre que vous souhaitez déposer",
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('description', TextType::class, [
                'label' => 'Décrivez votre offre',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('location', TextType::class, [
                'label' => 'Indiquez votre localisation',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('contractType', TextType::class, [
                'label' => 'Type de contrat proposé',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('salaryRange', TextType::class, [
                'label' => 'Indiquez votre exigence salariale',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('experienceReq', IntegerType::class, [
                'label' => "Indiquez l'expérience souhaitée",
                'attr' => ['class' => 'form-control'],
            ])
            ->add('skillsReq', TextType::class, [
                'label' => 'Indiquez les compétences souhaitées',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('datePosted', DateType::class, [
                'label' => 'Indiquez la date de publication',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('company', null, [
                'label' => 'Indiquez votre entreprise',
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control']])

            ->add('category', null, [
                'label' => 'Indiquez le métier recherché',
                'choice_label' => 'name',
                'attr' => ['class' => 'form-control'],
                'multiple' => false,
                'expanded' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
