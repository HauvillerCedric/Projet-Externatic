<?php

namespace App\Controller\Admin;

use App\Entity\Offer;
use App\Entity\Company;
use Doctrine\ORM\QueryBuilder;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class OfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Offer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {

        return $crud
        ->setEntityLabelInPlural('Offres')
        ->setEntityLabelInSingular('Une Offre')

        ->setPageTitle("index", 'Externatic -  Administration utilisateurs')
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                    ->hideOnForm(),
            AssociationField::new('company')->setLabel('Nom de l\'entreprise'),
            AssociationField::new('category')->setLabel('Metier')
                    ->autocomplete(),
            TextField::new('title')->setLabel('Titre d\'offre'),
            TextField::new('location')->setLabel('Localisation'),
            TextField::new('contractType')->setLabel('Type de contrat'),
            TextField::new('salaryRange')->setLabel('Salaire'),
            IntegerField::new('experienceReq')->setLabel('Anées d\'experiences'),
            TextField::new('skillsReq')->setLabel('Competences Requises'),
            DateTimeField::new('datePosted')->setLabel('Publication de l\'offre'),
            TextEditorField::new('description')
                    ->setFormType(CKEditorType::class)
                    ->hideOnIndex(),
            TextField::new('slug'),



        ];
    }
}
