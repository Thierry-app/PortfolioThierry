<?php

namespace App\Controller;

use App\Repository\CompetenceRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetenceController extends AbstractController
{
    #[Route('/admin/competences', name: 'competences')]
    public function index(CompetenceRepository $competenceRepository): Response
    {
        $competences = $competenceRepository->findAll();
        // on stocke ici (à la ligne suivante) la ligne compétence de la BDD
        return $this->render('/admin/competence.html.twig', [ 
            'competences' => $competences
        ]);
    }
}
