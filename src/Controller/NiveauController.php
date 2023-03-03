<?php

namespace App\Controller;

use App\Entity\Niveau;
use App\Form\NiveauFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/niveau')]
class NiveauController extends AbstractController
{
    
    #[Route('/list', name: 'app_niveau_list')]
    public function shows(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Niveau::class);
        $niveau = $repository->findBy(array(), array('name'=> 'ASC')) ;

        return $this->render('niveau/list.html.twig', [
            'titre' => 'Liste des Niveaux',
            'niveaux' => $niveau,
        ]);
    }
    
    #[Route('/{id<\d+>}/edit', name: 'app_niveau_edit')]
    public function editniveau(Request $request, Niveau $niveau,  EntityManagerInterface $entitymanager): Response
    {
        
        $form = $this->createForm(NiveauFormType::class, $niveau);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($niveau);
            $entitymanager->flush();
       
            return $this->redirectToRoute('app_niveau_list',[]);
            
        }    
        return $this->render('niveau/edit.html.twig', [
            'niveauForm' => $form->createView() ,
            'titre'      => 'Edit Niveau',
        ]);
    }
    
    #[Route('/ajout', name: 'app_niveau_ajout')]
    public function newNiveau(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $niveau = new  Niveau();
        $form = $this->createForm(NiveauFormType::class, $niveau);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($niveau);
            $entitymanager->flush();
        
            return $this->redirectToRoute('app_niveau_list',[]);
        
        }

        return $this->render('niveau/ajout.html.twig', [
            'niveauForm' => $form->createView() ,
            'titre'      => 'Ajout Niveau'
        ]);



        
    }

    #[Route('/detail/{id}', name: 'app_niveau_detail')]
    public function afficheLigne( Niveau $niveau): Response
    {
      
        return $this->render('niveau/detail.html.twig', [
            'niveauForm' => $niveau,
            'titre' => 'Détail niveau',
        ]);
    }

    #[Route('/{id}', name: 'app_niveau_delete')]
    public function delete(Request $reques, Niveau $niveau , EntityManagerInterface $entitymanager): Response
    {
      
        if (!$niveau) {
            throw $this->createNotFoundException('Unable to find Niveau entity.');
        }
    
        $entitymanager->remove($niveau);
        $entitymanager->flush();
        $this->addFlash(
            'success',
            "Niveau <strong>".$niveau->getName(). "lien été enregistré !"
        );
        return $this->redirectToRoute('app_niveau_list', [], Response::HTTP_SEE_OTHER);
    }

}
