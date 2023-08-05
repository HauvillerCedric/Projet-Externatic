<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Entity\User;
use App\Entity\Company;
use App\Form\OfferType;
use App\Entity\Category;
use App\Form\EntityType;
use App\Form\SearchProgramType;
use App\Form\CategorySelectType;
use App\Repository\UserRepository;
use App\Repository\OfferRepository;
use App\Repository\CompanyRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/offer')]
class OfferController extends AbstractController
{
    #[Route('/', name: 'app_offer', methods: ['GET', 'POST'])]
    public function index(
        OfferRepository $offerRepository,
        CategoryRepository $categoryRepository,
        Request $request
    ): Response {
        $categories = $categoryRepository->findAll();

        $form = $this->createForm(SearchProgramType::class, null, [
            'categories' => $categories,
            'method' => 'GET',
        ]);
        $form->handleRequest($request);

        $offers = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $search = $form->getData()['search'];
            $location = $form->getData()['location'];
            $category = $form->getData()['category'];
            $offers = $offerRepository->findLikeName($search, $location, $category);
        } else {
            $offers = $offerRepository->findAll();
        }

        foreach ($offers as $offer) {
            $category = $offer->getCategory();
            if ($category && !in_array($category, $categories)) {
                $categories[] = $category;
            }
        }
        return $this->render('offer/index.html.twig', [
            'offers' => $offers,
            'categories' => $categories,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/new', name: 'app_offer_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        OfferRepository $offerRepository,
        CompanyRepository $companyRepository,
        CategoryRepository $categoryRepository,
        SluggerInterface $slugger,
        UserRepository $userRepository
    ): Response {
        if (!$this->isGranted('ROLE_ENTREPRISE')) {
            return $this->redirectToRoute('app_offer');
        }

        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Merci de vous connecter pour déposer une offre.');
        }

        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($offer->getTitle());
            $offer->setSlug($slug);

            $offerRepository->save($offer, true);

            $user->addOffer($offer);
            $userRepository->save($user, true);

            $this->addFlash('success', 'Votre offre est crée avec succès');

            return $this->redirectToRoute('app_offer', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offer/new.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_offer_show', methods: ['GET'])]
    public function show(Offer $offer, SluggerInterface $slugger): Response
    {
        return $this->render('offer/show.html.twig', [
            'offer' => $offer,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_offer_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Offer $offer,
        OfferRepository $offerRepository,
        SluggerInterface $slugger
    ): Response {
        if (!$this->isGranted('ROLE_ENTREPRISE')) {
            return $this->redirectToRoute('app_offer');
        }
        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($offer->getTitle());
            $offer->setSlug($slug);

            $offerRepository->save($offer, true);

            $this->addFlash('success', 'Votre offre est modifiée avec succès');

            return $this->redirectToRoute('app_offer', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('offer/edit.html.twig', [
            'offer' => $offer,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_offer_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Offer $offer,
        OfferRepository $offerRepository,
        SluggerInterface $slugger
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $offer->getId(), $request->request->get('_token'))) {
            $offerRepository->remove($offer, true);
        }

        $this->addFlash('danger', 'Vous offre est supprimée');
        return $this->redirectToRoute('app_offer', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{slug}/watchlist', methods: ['GET', 'POST'], name: 'app_offer_watchlist')]
    public function addToWatchlist(Offer $offer, UserRepository $userRepository): Response
    {

        /** @var \App\Entity\User */
        $user = $this->getUser();
        if ($user->isInWatchlist($offer)) {
            $user->removeWatchlist($offer);
        } else {
            $user->addToWatchlist($offer);
        }

        $userRepository->save($user, true);

        return $this->redirectToRoute('app_offer', ['slug' => $offer->getSlug()]);
    }
}
