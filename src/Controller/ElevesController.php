<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Form\Eleves1Type;
use App\Repository\ElevesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/eleves')]
class ElevesController extends AbstractController
{
    #[Route('/', name: 'app_eleves_index', methods: ['GET'])]
    public function index(ElevesRepository $elevesRepository): Response
    {
        return $this->render('eleves/index.html.twig', [
            'eleves' => $elevesRepository->findAll(),
            'titre'=> 'Liste des eleves'
        ]);
    }

    #[Route('/new', name: 'app_eleves_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ElevesRepository $elevesRepository): Response
    {
        $elefe = new Eleves();
        $form = $this->createForm(Eleves1Type::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elevesRepository->save($elefe, true);

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleves/new.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_eleves_show', methods: ['GET'])]
    public function show(Eleves $elefe): Response
    {
        return $this->render('eleves/show.html.twig', [
            'elefe' => $elefe,
            'titre' => 'detail eleves',
        ]);
    }

    #[Route('/{id}/edit', name: 'app_eleves_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Eleves $elefe, ElevesRepository $elevesRepository): Response
    {
        $form = $this->createForm(Eleves1Type::class, $elefe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $elevesRepository->save($elefe, true);

            return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('eleves/edit.html.twig', [
            'elefe' => $elefe,
            'form' => $form,
            'titre' => 'edit eleves',
        ]);
    }

    #[Route('/{id}', name: 'app_eleves_delete', methods: ['POST'])]
    public function delete(Request $request, Eleves $elefe, ElevesRepository $elevesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$elefe->getId(), $request->request->get('_token'))) {
            $elevesRepository->remove($elefe, true);
        }

        return $this->redirectToRoute('app_eleves_index', [], Response::HTTP_SEE_OTHER);
    }
}
