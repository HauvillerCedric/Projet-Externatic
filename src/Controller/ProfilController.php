<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;
use App\Entity\Watchlist;
use App\Repository\UserRepository;
use App\Repository\ProfilRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_CANDIDAT')]
#[Route('/profil')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'app_profil_index', methods: ['GET'])]
    public function index(ProfilRepository $profilRepository): Response
    {

        $profil = $profilRepository->findOneBy(['user' => $this->getUser()]);
        return $this->render('profil/index.html.twig', [

            'profil' => $profil,
        ]);
    }

    #[Route('/new', name: 'app_profil_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ProfilRepository $profilRepository,
        SluggerInterface $slugger,
        UserRepository $userRepository
    ): Response {
        $user = $this->getUser();
        $profil = new Profil();
        $profil->setUser($user);
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($profil->getTitleProfil());
            $profil->setSlug($slug);


            $profilRepository->save($profil, true);

            $this->addFlash('success', 'Vous avez créez votre profil');

            return $this->redirectToRoute('app_profil_index', [
                'profil' => $profil,
            ]);
        }

        return $this->renderForm('profil/new.html.twig', [
            'profil' => $profil,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_profil_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Profil $profil,
        ProfilRepository $profilRepository,
        SluggerInterface $slugger,
        TokenStorageInterface $tokenStorage
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $profil->getId(), $request->request->get('_token'))) {
            $profilRepository->remove($profil, true);

            // Forcer la déconnexion de l'utilisateur
            $tokenStorage->setToken(null);
        }

        $this->addFlash('danger', 'Votre compte est supprimé');

        return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{slug}', name: 'app_profil_show', methods: ['GET'])]
    public function show(Profil $profil, SluggerInterface $slugger): Response
    {
        return $this->render('profil/show.html.twig', [
            'profil' => $profil,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_profil_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Profil $profil,
        ProfilRepository $profilRepository,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(ProfilType::class, $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $profilRepository->save($profil, true);

            $this->addFlash('success', 'Votre profil est modifié avec succès');

            return $this->redirectToRoute('app_profil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil/edit.html.twig', [
            'profil' => $profil,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/favoris', name: 'app_profil_favoris', methods: ['POST', 'GET'])]
    public function showFavorites(Request $request, Profil $profil): Response
    {
        // Récupérer l'utilisateur connecté
        $user = $this->getUser();
        // Récupérer les offres en favoris de l'utilisateur
        $favorites = $user->getWatchlist();

        // Passer les offres en favoris à la vue
        return $this->render('profil/favorites.html.twig', [
            'favorites' => $favorites,
            'profil' => $profil,
        ]);
    }
}
