<?php

namespace App\Controller\Admin;

use App\Entity\Mailer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class MailerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mailer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('E-mails')
        ->setEntityLabelInSingular('E-mail')

        ->setPageTitle("index", 'Externatic -  Administration emails')

        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                  ->hideOnForm()
                  ->hideOnIndex(),
            TextField::new('name')->setLabel('Prenom'),
            AssociationField::new('subject')->setLabel('Sujet'),
            TextField::new('email'),
            TextField::new('phone')->setLabel('Télephone'),
            TextEditorField::new('description')

        ];
    }
}
