<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(EntityManagerInterface $em, Request $request): Response
    {
        
        $commentaires = $em->getRepository(Commentaire::class)->findAll(); // Récupérer des données

        $username = $this->getUser();

        $commentaire = new Commentaire(); // Champ Null du formulaire 
        $formCom = $this->createForm(CommentaireType::class,$commentaire); // Le formulaire 
        $formCom->handleRequest($request); 

        if($formCom->isSubmitted() && $formCom->isValid()){

            $commentaire->setAuteur($username);
            $em->persist($commentaire);
            $em->flush();

            $this->addFlash('success', 'Commentaire ajouté'); // 
            return $this->redirectToRoute(route: 'app_commentaire');  
        };

        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
            'commentaires' => $commentaires,
            'formCom' => $formCom,
        ]);
    }

    #[Route('/commentaire/{id}', 'commentaire_delete')]
    public function delete(EntityManagerInterface $em, ?Commentaire $commentaire = null){
        if($commentaire === null){
            return $this->redirectToRoute('app_commentaire');
        }
        
        $em->remove($commentaire);
        $em->flush();

        $this->addFlash(type:'success', message:'Commentaire supprimé');
        return $this->redirectToRoute('app_commentaire');
    }
}
