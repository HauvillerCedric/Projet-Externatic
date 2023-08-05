<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Offer;
use App\Entity\Company;
use App\Entity\Mailer;
use App\Entity\Category;
use App\Entity\Profil;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

        return $this->render('admin/dashboard.html.twig');
    }
    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setAvatarUrl($user->getAvatarUrl())
            ->addMenuItems([
                MenuItem::linkToUrl('My Profile', 'fas fa-user', $this->generateUrl('app_profile'))
            ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setFaviconPath('/assets/images/favicon-externatic-couleur.png')
            ->setTitle('<img src="/assets/images/logo-externatic-couleur-white.svg">')
            ->renderContentMaximized();
    }



    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToUrl('Accueil', 'fas fa-home', $this->generateUrl('app_home'));

        yield MenuItem::section('Profils');
        yield MenuItem::subMenu('Candidats', 'fas fa-user-group', Profil::class)->setSubItems([
            //MenuItem::linkToCrud('Crée candidat', 'fas fa-plus', Profil::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les candidats', 'fas fa-eye', Profil::class)
         ]);

        yield MenuItem::subMenu('Entreprises', 'fas fa-city', Company::class)->setSubItems([
            MenuItem::linkToCrud('Crée entreprise', 'fas fa-plus', Company::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les entreprises', 'fas fa-eye', Company::class)
        ]);

        yield MenuItem::section('Contact');
        yield MenuItem::subMenu('Nous contacter', 'fa fa-envelope', Mailer::class)->setSubItems([
            MenuItem::linkToCrud('Crée email', 'fas fa-plus', Mailer::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les emails', 'fas fa-eye', Mailer::class)
        ]);

        yield MenuItem::section('Categories');
        yield MenuItem::subMenu('Les categories', 'fas fa-list-ul', Category::class)->setSubItems([
            MenuItem::linkToCrud('Créer une categorie', 'fas fa-plus', Category::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Categories', 'fas fa-eye', Category::class)
        ]);
        yield MenuItem::section('Offres');
        yield MenuItem::subMenu('Les offres', 'fas fa-bolt', Offer::class)->setSubItems([
            MenuItem::linkToCrud('Créer une offre', 'fas fa-plus', Offer::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Offres', 'fas fa-eye', Offer::class),

        ]);
        yield MenuItem::section('Tous les utilisateurs');
        yield MenuItem::linkToCrud('Candidats et entreprise', 'fas fa-handshake', User::class);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin');
    }
}
