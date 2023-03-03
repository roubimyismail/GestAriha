<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/classe')]
class ClasseController extends AbstractController
{
    #[Route('/{id<\d+>}/edit', name: 'app_classe_edit')]
    public function editClasse(Request $request, Classe $classe,  EntityManagerInterface $entitymanager): Response
    {
        
        $form = $this->createForm(ClasseFormType::class, $classe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($classe);
            $entitymanager->flush();
       
            return $this->redirectToRoute('app_classe_list',[]);
            
        }    
        return $this->render('classe/edit.html.twig', [
            'classeForm' => $form->createView() ,
            'titre'      => 'Edit Classe',
        ]);
    }
    
    #[Route('/list', name: 'app_classe_list')]
    public function shows(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Classe::class);
        $classe = $repository->findBy(array(), array('name' => 'ASC'));

        return $this->render('classe/list.html.twig', [
            'titre' => 'Liste des Classes',
            'classes' => $classe,
        ]);
    }
    
    #[Route('/ajout', name: 'app_classe_ajout')]
    public function newClasse(Request $request, EntityManagerInterface $entitymanager): Response
    {
        $classe = new  Classe();
        $form = $this->createForm(ClasseFormType::class, $classe);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entitymanager->persist($classe);
            $entitymanager->flush();
        
            return $this->redirectToRoute('app_classe_list',[]);
        
        }

        return $this->render('classe/ajout.html.twig', [
            'classeForm' => $form->createView() ,
            'titre'      => 'Ajout Classe'
        ]);



        
    }

    #[Route('/detail/{id}', name: 'app_classe_detail')]
    public function afficheLigne( Classe $classe): Response
    {
      
        return $this->render('classe/detail.html.twig', [
            'classeForm' => $classe,
            'titre' => 'Détail Classe',
        ]);
    }

    #[Route('/{id}', name: 'app_classe_delete')]
    public function delete(Request $reques, Classe $classe , EntityManagerInterface $entitymanager): Response
    {
      
        if (!$classe) {
            throw $this->createNotFoundException('Unable to find Classe entity.');
        }
    
        $entitymanager->remove($classe);
        $entitymanager->flush();
        $this->addFlash(
            'success',
            "Classe <strong>".$classe->getName(). "lien été enregistré !"
        );
        return $this->redirectToRoute('app_classe_list', [], Response::HTTP_SEE_OTHER);
    }

}
