<?php

namespace App\Controller;

use App\Entity\Eleves;
use App\Form\ElevesType;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/eleve')]
class EleveController extends AbstractController
{
     
    #[Route('/ajout', name: 'app_eleve_ajout')]
    public function newEleve(Request $request,  EntityManagerInterface $entitymanager, SluggerInterface $slugger ): Response
    {
        $eleve = new Eleves();
        $form = $this->createForm(ElevesType::class, $eleve);
        $form->handleRequest($request);
        
        
            if ($form->isSubmitted() && $form->isValid()) {
                /** @var UploadedFile $imageFile */
                $imageFile = $form->get('image')->getData();
    
                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($imageFile) {
                    $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
    
                    // Move the file to the directory where brochures are stored
                    try {
                        $imageFile->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
    
                    // updates the 'imageFilename' property to store the PDF file name
                    // instead of its contents
                    $eleve->setImage($newFilename);
                }
           
            $entitymanager->persist($eleve);
            $entitymanager->flush();
            $this->addFlash(
                'success',
                "Eléve <strong>".$eleve->getFirstname(). " " .$eleve->getLastname(). " " . "a bien été enregistré !"
            );
            return $this->redirectToRoute('app_eleve_list',[
                    
                    
            ]);
        
        
    }
        return $this->render('eleve/ajout.html.twig', [
            'eleveForm' => $form->createView() ,
            'titre' => 'Nouveau éléve',
           
        ]);
    }


    #[Route('/{id}/edit', name: 'app_eleve_edit')]
    public function editEleve(Request $request, Eleves $eleve ,EntityManagerInterface $entitymanager, SluggerInterface $slugger ): Response
    {
        $form = $this->createForm(ElevesType::class, $eleve);
        //$imageFile = $eleve->getImage();
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid() ){
            
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
    
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'imageFilename' property to store the PDF file name
                // instead of its contents
                $eleve->setImage($newFilename);
            }
            $entitymanager->persist($eleve);
            $entitymanager->flush();
            $this->addFlash(
                'success',
                "Eléve <strong>".$eleve->getFirstname(). " " .$eleve->getLastname(). " " . "a bien été enregistré !"
            );
            return $this->redirectToRoute('app_eleve_list',[
                    
                    
            ]);
        }
        
        
        return $this->render('eleve/edit.html.twig', [
            'eleveForm' => $form->createView() ,
            'titre' => 'Edit éléve',
            
        ]);
    }

    // show one eleve
    #[Route('/list', name: 'app_eleve_list')]
    public function shows(ManagerRegistry $doctrine): Response {
        $repository = $doctrine->getRepository(Eleves::class) ;
        $eleve = $repository->findBy(array(), array(
            'lastname' => 'ASC',
            'firstname' => 'ASC',
            ));
        return $this->render('eleve/list.html.twig',[
            'eleves' => $eleve,
            'titre' => 'Liste des éléves',
        ]);
    }

    #[Route('/detail/{id}', name: 'app_eleve_detail')]
    public function afficheLigne( Eleves $eleve): Response
    {
      
        return $this->render('eleve/detail.html.twig', [
            'eleveForm' => $eleve,
            'titre' => 'Détail eléve',
        ]);
    }

    #[Route('/{id}', name: 'app_eleve_delete')]
    public function delete(Request $reques, Eleves $eleve , EntityManagerInterface $entitymanager): Response
    {
      
        if (!$eleve) {
            throw $this->createNotFoundException('Unable to find Preisliste entity.');
        }
    
        $entitymanager->remove($eleve);
        $entitymanager->flush();
        $this->addFlash(
            'success',
            "Eléve <strong>".$eleve->getFirstname(). " " .$eleve->getLastname(). " " . "a bien été enregistré !"
        );
        return $this->redirectToRoute('app_eleve_list', [], Response::HTTP_SEE_OTHER);
    }
}
