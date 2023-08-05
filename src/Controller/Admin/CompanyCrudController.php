<?php

namespace App\Controller\Admin;

use DateTime;
use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Entreprises')
        ->setEntityLabelInSingular('Entreprise')

        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                        ->hideOnIndex()
                        ->hideOnForm(),
            TextField::new('name')->setLabel('Nom de votre entreprise'),
            TextField::new('location')->setLabel('Localisation'),
            DateTimeField::new('updated_at')->setLabel('Mis à jour')
                        ->setFormTypeOption('disabled', 'disabled')
                        ->hideOnForm(),
            ImageField::new('poster')->setLabel('Ajoutez votre logo')
                        ->setBasePath('uploads/images/posters')
                        ->setUploadDir('public/uploads/images/posters')
                        ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]'),
            TextField::new('description')->setLabel('Description d\'offre')
                        ->setFormType(CKEditorType::class),
             TextField::new('slug'),

        ];
    }
}
