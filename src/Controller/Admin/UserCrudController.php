<?php

namespace App\Controller\Admin;

use App\Entity\User;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Utilisateurs')
        ->setEntityLabelInSingular('Utilisateur')

        ->setPageTitle("index", 'Externatic -  Administration utilisateurs')
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_ADMIN', 'ROLE_CANDIDAT', 'ROLE_ENTREPRISE', 'ROLE_USER'];

        return [
            IdField::new('id')
                    ->hideOnForm(),
            TextField::new('fullName')->setLabel('Nom et prenom')
                    ->hideOnForm(),
            TextField::new('firstname')->setLabel('Prenom')
                //     ->setFormTypeOption('disabled', 'disabled')
                    ->onlyOnForms(),
            TextField::new('lastname')->setLabel('Nom')
                    ->onlyOnForms(),
                //     ->setFormTypeOption('disabled', 'disabled'),
            AvatarField::new('avatar')
                    ->formatValue(static function ($value, ?User $user) {
                        return $user?->getAvatarUrl();
                    }),

                //  ->hideOnForm(),
            ImageField::new('avatar')
                    ->setBasePath('uploads/avatars')
                    ->setUploadDir('public/uploads/avatars')
                    ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                    ->onlyOnForms(),
            EmailField::new('email'),
                //     ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('phone')->setLabel('Téléphone'),
                //     ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('password')->setLabel('Mot de passe')
                    ->hideOnIndex(),

            DateTimeField::new('createdAt')->setLabel('Publication de l\'offre')
                    ->hideOnForm(),
            ChoiceField::new('roles')
                    ->setChoices(array_combine($roles, $roles))
                    ->allowMultipleChoices()
                    ->renderExpanded()
                    ->renderAsBadges(),
            TextField::new('slug')
                  ->hideOnIndex()
                  ->hideOnForm(),
            ArrayField::new('roles')
                    ->hideOnIndex(),
            DateTimeField::new('createdAt')->setLabel(' Date de publication'),
            DateTimeField::new('updatedAt')->setLabel('Mise à jour le')
                    ->setFormTypeOption('disabled', 'disabled')
                    ->hideOnForm(),
            TextEditorField::new('message')
                     ->setFormType(CKEditorType::class),
        ];
    }
}
