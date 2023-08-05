<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use App\Repository\CompanyRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/company')]
class CompanyController extends AbstractController
{
    #[Route('/', name: 'app_company', methods: ['GET'])]
    public function index(
        CompanyRepository $companyRepository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $company = $companyRepository->findAll();
        $company = $paginator->paginate($company, $request->query->getInt('page', 1), 8);

        return $this->render('company/index.html.twig', [
            'company' => $company,
        ]);
    }
    #[Route('/new', name: 'app_company_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CompanyRepository $companyRepository, SluggerInterface $slugger): Response
    {
        if (!$this->isGranted('ROLE_ENTREPRISE')) {
            return $this->redirectToRoute('app_offer');
        }

        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Merci de vous connecter pour déposer une offre.');
        }

        $company = new Company();
        $company->setUser($user);

        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($company->getName());
            $company->setSlug($slug);
            $companyRepository->save($company, true);

            return $this->redirectToRoute('app_company', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/new.html.twig', [
        'company' => $company,
        'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_company_show', methods: ['GET'])]
    public function show(Company $company, SluggerInterface $slugger): Response
    {
        return $this->render('company/show.html.twig', [
            'company' => $company,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_company_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Company $company,
        CompanyRepository $companyRepository,
        SluggerInterface $slugger
    ): Response {
        if (!$this->isGranted('ROLE_ENTREPRISE')) {
            return $this->redirectToRoute('app_company');
        }
        $form = $this->createForm(CompanyType::class, $company);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = $slugger->slug($company->getName());
            $company->setSlug($slug);

            $companyRepository->save($company, true);

            return $this->redirectToRoute('app_company', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('company/edit.html.twig', [
            'company' => $company,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_company_delete', methods: ['POST'])]
    public function delete(
        Request $request,
        Company $company,
        CompanyRepository $companyRepository,
        SluggerInterface $slugger
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $company->getId(), $request->request->get('_token'))) {
            $companyRepository->remove($company, true);
        }
        return $this->redirectToRoute('app_company', [], Response::HTTP_SEE_OTHER);
    }
}
