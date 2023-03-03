<?php

namespace App\Controller;

use App\Entity\Anneescolaire;
use App\Form\AnneescolaireFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/anneescolaire')]
class AnneescolaireController extends AbstractController
{
    #[Route('/{id<\d+>}/edit', name: 'app_anneescolaire_edit')]
    public function editAnneescolaire(Request $request, Anneescolaire $anneescolaire,  EntityManagerInterface $entitymanager): Response
    {
        
        $form = $this->createForm(AnneescolaireFormType::class, $anneescolaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($anneescolaire);
            $entitymanager->flush();
       
           return $this->redirectToRoute('app_anneescolaire_list',[]);
            
        }    
        return $this->render('anneescolaire/edit.html.twig', [
            'anneescolaireForm' => $form->createView() ,
            'titre'      => 'Edit Annee Scolaire',
        ]);  
    }
    
    #[Route('/list', name: 'app_anneescolaire_list')]
    public function shows(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Anneescolaire::class);
        $anneescolaire = $repository->findBy(array(), array('annee' => 'ASC'));

        return $this->render('anneescolaire/list.html.twig', [
            'titre' => 'Liste des Anneescolairex',
            'anneescolaires' => $anneescolaire,
        ]);
    }
    
    #[Route('/ajout', name: 'app_anneescolaire_ajout')]
    public function newAnneescolaire(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $anneescolaire = new  Anneescolaire();
        $form = $this->createForm(AnneescolaireFormType::class, $anneescolaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($anneescolaire);
            $entitymanager->flush();
        
            return $this->redirectToRoute('app_anneescolaire_list',[]);
        
        }

        return $this->render('anneescolaire/ajout.html.twig', [
            'anneescolaireForm' => $form->createView() ,
            'titre'      => 'Ajout Annee Scolaire'
        ]);



        
    }

    #[Route('/detail/{id}', name: 'app_anneescolaire_detail')]
    public function afficheLigne( Anneescolaire $anneescolaire): Response
    {
      
        return $this->render('Anneescolaire/detail.html.twig', [
            'anneescolaireForm' => $anneescolaire,
            'titre' => 'Détail Anneescolaire',
        ]);
    }

    #[Route('/{id}', name: 'app_anneescolaire_delete')]
    public function delete(Request $reques, Anneescolaire $anneescolaire , EntityManagerInterface $entitymanager): Response
    {
      
        if (!$anneescolaire) {
            throw $this->createNotFoundException('Unable to find Anneescolaire entity.');
        }
    
        $entitymanager->remove($anneescolaire);
        $entitymanager->flush();
        $this->addFlash(
            'success',
            "Annee scolaire <strong>".$anneescolaire->getAnnee(). "lien été enregistré !"
        );
        return $this->redirectToRoute('app_anneescolaire_list', [], Response::HTTP_SEE_OTHER);
    }

}
