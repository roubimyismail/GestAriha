<?php

namespace App\Controller;

use App\Entity\Enseignants;
use App\Form\Enseignants1Type;
use App\Repository\EnseignantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/enseig/crud')]
class EnseigCrudController extends AbstractController
{
    #[Route('/', name: 'app_enseig_crud_index', methods: ['GET'])]
    public function index(EnseignantsRepository $enseignantsRepository): Response
    {
        return $this->render('enseig_crud/index.html.twig', [
            'enseignants' => $enseignantsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_enseig_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EnseignantsRepository $enseignantsRepository): Response
    {
        $enseignant = new Enseignants();
        $form = $this->createForm(Enseignants1Type::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enseignantsRepository->save($enseignant, true);

            return $this->redirectToRoute('app_enseig_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enseig_crud/new.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enseig_crud_show', methods: ['GET'])]
    public function show(Enseignants $enseignant): Response
    {
        return $this->render('enseig_crud/show.html.twig', [
            'enseignant' => $enseignant,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_enseig_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enseignants $enseignant, EnseignantsRepository $enseignantsRepository): Response
    {
        $form = $this->createForm(Enseignants1Type::class, $enseignant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $enseignantsRepository->save($enseignant, true);

            return $this->redirectToRoute('app_enseig_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('enseig_crud/edit.html.twig', [
            'enseignant' => $enseignant,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_enseig_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Enseignants $enseignant, EnseignantsRepository $enseignantsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enseignant->getId(), $request->request->get('_token'))) {
            $enseignantsRepository->remove($enseignant, true);
        }

        return $this->redirectToRoute('app_enseig_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
