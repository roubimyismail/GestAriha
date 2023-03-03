<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/matiere')]
class MatiereController extends AbstractController
{
    #[Route('/{id<\d+>}/edit', name: 'app_matiere_edit')]
    public function editmatiere(Request $request, Matiere $matiere,  EntityManagerInterface $entitymanager): Response
    {
        
        $form = $this->createForm(MatiereFormType::class, $matiere);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($matiere);
            $entitymanager->flush();
       
            return $this->redirectToRoute('app_matiere_list',[]);
            
         }    
         return $this->render('matiere/edit.html.twig', [
            'matiereForm' => $form->createView() ,
            'titre'      => 'Edit Matiere',
        ]);
    }
    
    #[Route('/list', name: 'app_matiere_list')]
    public function shows(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Matiere::class);
        $matiere = $repository->findBy(array(), array('name' => 'ASC'));

        return $this->render('matiere/list.html.twig', [
            'titre' => 'Liste des matierex',
            'matieres' => $matiere,
        ]);
    }
    
    #[Route('/ajout', name: 'app_matiere_ajout')]
    public function newmatiere(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $matiere = new  Matiere();
        $form = $this->createForm(MatiereFormType::class, $matiere);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($matiere);
            $entitymanager->flush();
        
            return $this->redirectToRoute('app_matiere_list',[]);
        
        }

        return $this->render('matiere/ajout.html.twig', [
            'matiereForm' => $form->createView() ,
            'titre'      => 'Ajout matiere'
        ]);



        
    }

    #[Route('/detail/{id}', name: 'app_matiere_detail')]
    public function afficheLigne( Matiere $matiere): Response
    {
      
        return $this->render('matiere/detail.html.twig', [
            'matiereForm' => $matiere,
            'titre' => 'Détail matiere',
        ]);
    }

    #[Route('/{id}', name: 'app_matiere_delete')]
    public function delete(Request $reques, Matiere $matiere , EntityManagerInterface $entitymanager): Response
    {
      
        if (!$matiere) {
            throw $this->createNotFoundException('Unable to find matiere entity.');
        }
    
        $entitymanager->remove($matiere);
        $entitymanager->flush();
        $this->addFlash(
            'success',
            "matiere <strong>".$matiere->getName(). "lien été enregistré !"
        );
        return $this->redirectToRoute('app_matiere_list', [], Response::HTTP_SEE_OTHER);
    }

}
