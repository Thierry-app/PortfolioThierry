<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CompetenceRepository $competenceRepository): Response
    {
        $competences = $competenceRepository->findAll();
       // var_dump($competences);
        //die($competences); ou die;
        return $this->render('home/index.html.twig', [
            'competences' => $competences
        ]);
    }
}
