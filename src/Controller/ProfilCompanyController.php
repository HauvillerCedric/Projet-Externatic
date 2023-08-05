<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Profil;
use App\Form\Company1Type;
use App\Repository\CompanyRepository;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[IsGranted('ROLE_ENTREPRISE')]
#[Route('/profil/company')]
class ProfilCompanyController extends AbstractController
{
    #[Route('/', name: 'app_profil_company_index', methods: ['GET'])]
    public function index(CompanyRepository $companyRepository): Response
    {
        $company = $companyRepository->findOneBy(['user' => $this->getUser()]);
        return $this->render('profil_company/index.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/new', name: 'app_profil_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyRepository $companyRepository, SluggerInterface $slugger): Response
    {
        if (!$this->isGranted('ROLE_ENTREPRISE')) {
            return $this->redirectToRoute('app_offer');
        }

        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour déposer une offre.');
        }

        $company = new Company();
        $company->setUser($user);

        $form = $this->createForm(Company1Type::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($company->getName());
            $company->setSlug($slug);
            $companyRepository->save($company, true);

            $this->addFlash('success', 'Vous avez créez votre entreprise');

            return $this->redirectToRoute('app_profil_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil_company/new.html.twig', [
        'company' => $company,
        'form' => $form,
        ]);
    }

     #[Route('/{slug}', name: 'app_profil_company_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Company $company,
        CompanyRepository $companyRepository,
        SluggerInterface $slugger
    ): Response {
         if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->request->get('_token'))) {
             $companyRepository->remove($company, true);
         }
         $this->addFlash('danger', 'Vous entreprise est supprimée');

         return $this->redirectToRoute('app_profil_company_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{slug}', name: 'app_profil_company_show', methods: ['GET'])]
    public function show(Company $company, SluggerInterface $slugger): Response
    {
        return $this->render('profil_company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_profil_company_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Company $company,
        CompanyRepository $companyRepository,
        SluggerInterface $slugger
    ): Response {
        $form = $this->createForm(Company1Type::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $companyRepository->save($company, true);

            $this->addFlash('success', 'Vous entreprise est modifiée avec succès');

            return $this->redirectToRoute('app_profil_company_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('profil_company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/mesOffres', name: 'app_profil_company_mesOffres', methods: ['POST', 'GET'])]
    public function showMesOffres(Request $request, Company $company): Response
    {
        // Récupérer les offres postées par la company
        $mesOffres = $company->getOffers();

        // Passer les offres à la vue
        return $this->render('profil_company/mesOffres.html.twig', [
            'mesOffres' => $mesOffres,
            'company' => $company,
        ]);
    }
}
