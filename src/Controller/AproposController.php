<?php

namespace App\Controller;

use App\Form\AProposType;
use App\Repository\AProposRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AproposController extends AbstractController
{
    #[Route('/admin/a-propos', name: 'a_propos')]//dans admin car non modifiable par l'utilisateur
    public function index(AProposRepository $aProposRepository, Request $request): Response
    {
        $aPropos = $aProposRepository->find(1);// tableau avec une seule ligne
        $form = $this->createForm(AProposType::class, $aPropos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($aPropos);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'le contenu de la section à propos a bien été modifié');
       }

        return $this->render('admin/aPropos.html.twig', [
            'aProposForm' => $form->createView(),
        ]);
    }
}
