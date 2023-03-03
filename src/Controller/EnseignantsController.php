<?php

namespace App\Controller;

use App\Entity\Enseignants;
use App\Form\EnseignantsType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\EnseignantsRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/enseignant')]
class EnseignantsController extends AbstractController
{
    #[Route('/list', name: 'app_enseignant_list', methods: ['GET'])]
    public function index(EnseignantsRepository $enseignantsRepository): Response
    {
        return $this->render('enseignant/list.html.twig', [
            'enseignants' => $enseignantsRepository->findBy(array(), array(
                    'lastname' => 'ASC', 
                    'firstname' => 'ASC',
                )),
        ]);
    }

    #[Route('/ajout', name: 'app_enseignant_ajout', methods: ['GET', 'POST'])]
    public function newEnseignant(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $enseignant = new Enseignants();
        $form = $this->createForm(EnseignantsType::class, $enseignant);
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
               $enseignant->setImage($newFilename);
           
           }
                      
            $entityManager->persist($enseignant);
            $entityManager->flush();
                      
            return $this->redirectToRoute('app_enseignant_list',[
                    
                    
            ]);
            
        
        }
        return $this->render('enseignant/ajout.html.twig', [
            'titre' => 'Ajout Enseignant',
            'enseignantForm' => $form->createView(),
        ]);
    }

    #[Route('/detail/{id}', name: 'app_enseignant_detail')]
    public function show(Enseignants $enseignant): Response
    {
        return $this->render('enseignant/detail.html.twig', [
            'enseignant' => $enseignant,
        ]);
    }

    
    #[Route('/{id}/edit', name: 'app_enseignant_edit')]
    public function editEnseignant(Request $request, Enseignants $enseignant, EntityManagerInterface $entitymanager, SluggerInterface $slugger): Response
    {
        
        $form = $this->createForm(EnseignantsType::class, $enseignant);
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
               $enseignant->setImage($newFilename);
           
           }
                     
            $entitymanager->persist($enseignant);
            $entitymanager->flush();
            $this->addFlash(
                'success',
                "Enseignant <strong>".$enseignant->getFirstname(). " " .$enseignant->getLastname(). " " . "a bien été enregistré !"
            );
            return $this->redirectToRoute('app_enseignant_list',[
                    
                    
            ]);
            
        
        }
        return $this->render('enseignant/edit.html.twig', [
            'titre' => 'Modifier Enseignant',
            'enseignantForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_enseignant_delete')]
    public function delete(Request $request, Enseignants $enseignant, EntityManagerInterface $entityManager): Response
    {
        /*if ($this->isCsrfTokenValid('delete'.$enseignant->getId(), $request->request->get('_token'))) {
            $enseignantsRepository->remove($enseignant, true);
        }*/
    
        if (!$enseignant) {
            throw $this->createNotFoundException('Unable to find Preisliste entity.');
        }
    
        $entityManager->remove($enseignant);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_enseignant_list', [], Response::HTTP_SEE_OTHER);
    }
}
