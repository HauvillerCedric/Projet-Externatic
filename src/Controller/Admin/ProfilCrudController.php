<?php

namespace App\Controller\Admin;

use App\Entity\Profil;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProfilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Profil::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Profils')
        ->setEntityLabelInSingular('Profil')

        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }


    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')
                     ->hideOnForm()
                     ->hideOnIndex(),
            TextField::new('title_profil')->setLabel('Prénom')
                     ->hideOnForm(),
            TextField::new('location_profil')->setLabel('Localisation')
                     ->hideOnForm(),
            NumberField::new('mobility')->setLabel('Zone géographique (km)')
                     ->hideOnForm(),
            IntegerField::new('experience_year')->setLabel('Années d\'expériences')
                     ->hideOnForm(),
            TextField::new('skills')->setLabel('Compétences')
                     ->hideOnForm(),
            TextField::new('education')->setLabel('Formation')
                     ->hideOnForm(),
            TextField::new('language')->setLabel('Langues parlées')
                     ->hideOnForm(),
            DateTimeField::new('birth_day')->setLabel('Date de naissance')
                     ->hideOnForm(),
            // ImageField::new('document')->setLabel('CV')
            //          ->setFormType(VichFileType::class)
            //          ->setBasePath('uploads/pdf/')
            //          ->setUploadDir('public/uploads/pdf/')
            //          ->setUploadedFileNamePattern('[randomhash].[extension]')
            //          ->setFormTypeOptions(['attr' => [
            //             'accept' => 'application/pdf'
            //         ]]),

            ImageField::new('poster')->setLabel('Déposer votre image')
                    ->setBasePath('uploads/images/posters')
                    ->setUploadDir('public/uploads/images/posters')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->hideOnForm(),
            AvatarField::new('avatar')->setLabel('Avatar')
                    ->formatValue(static function ($value, ?Profil $profil) {
                        return $profil?->getAvatarUrl();
                    }),
            ImageField::new('avatar')->setLabel('Avatar')
                    ->setBasePath('uploads/avatars')
                    ->setUploadDir('public/uploads/avatars')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->onlyOnForms(),
            DateTimeField::new('updated_at')->setLabel('Mise à jour')
                    ->setFormTypeOption('disabled', 'disabled')
                    ->hideOnForm()
                    ->hideOnForm(),
            TextEditorField::new('description_profil')
                    ->setFormType(CKEditorType::class)
                    ->hideOnForm(),

        ];
    }
}
