<?php

namespace App\Controller;

use App\Entity\Realisations;
use App\Form\RealisationsType;
use App\Repository\RealisationsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class RealisationsController extends AbstractController
{
    #[Route('admin/realisations', name: 'realisations')]//Read
    public function index(RealisationsRepository $realisationsRepository): Response
    {
        $realisations = $realisationsRepository->findAll();
        return $this->render('admin/realisations.html.twig', [
            'realisations' => $realisations
        ]);
    }

    #[Route('/admin/realisations/create', name: 'create_realisations')]//Création
    public function createRealisations(Request $request)
    {        //création d'une nouvelle réalisation (vierge) :
        $realisations = new Realisations();
        $form= $this->createForm(RealisationsType::class, $realisations);// création du formulaire avec paramètre de nouvelle réalisation
        $form->handleRequest(($request)); //Est-ce que le formulaire a bien été fait ? gestionnaire de requête HTTP

        //gestion des données


        return $this->render('admin/realisationsForm.html.twig', [
            'realisationForm' => $form->createView() // création de la vue du formulaire et envoie à la vue (fichier)
        ]);
    }
}
