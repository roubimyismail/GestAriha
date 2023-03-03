<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvaluationController extends AbstractController
{
    #[Route('/evaluation', name: 'app_evaluation')]
    public function index(): Response
    {
        return $this->render('evaluation/index.html.twig', [
            'message' => 'En cours de realisation',
            'titre' => 'Salamoalikom baki matgadatch',
        ]);
    }
}
