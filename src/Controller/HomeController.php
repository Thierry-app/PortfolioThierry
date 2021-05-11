<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\AProposRepository;
use App\Repository\CompetenceRepository;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CompetenceRepository $competenceRepository, AProposRepository $aProposRepository, Request $request, Swift_Mailer $mailer): Response
    {
        $competences = $competenceRepository->findAll();
        $aPropos = $aProposRepository->find(1);

        $form = $this->createForm(ContactType::class); // crée le formulaire de contact
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData(); // récupère les informations du formulaire
            $mail = (new Swift_Message('Portfolio - ' . $contact['objet'])) // prépare le mail (avec son titre)
                ->setFrom($contact['email']) // définit l'expéditeur
                ->setTo('applications.thierry@gmail.com') // définit le destinataire
                ->setBody( // définit le corps du message
                    $this->renderView('contact/emailContact.html.twig', [ // passe les informations du formulaire au template de mail
                        'nom' =>  $contact['nom'],
                        'prenom' =>  $contact['prenom'],
                        'email' =>  $contact['email'],
                        'objet' =>  $contact['objet'],
                        'message' => $contact['message']
                    ]),
                    'text/html' // définit le format du message
                )
            ;
            $mailer->send($mail);
            // message de succès
            return $this->redirectToRoute('home');
        }

        return $this->render('home/index.html.twig', [
            'competences' => $competences,
            'aPropos' => $aPropos,
            'contactForm' => $form->createView()
        ]);
    }
}