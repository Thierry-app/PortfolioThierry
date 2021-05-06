<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Form\CompetenceType;
use App\Repository\CompetenceRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/admin/competences/create', name:'create_competence')]
    public function createCompetence(Request $request)
        {
        $competence = new Competence(); // création d'une nouvelle compétence
        $form=$this->createForm(CompetenceType::class, $competence); // création du formulaire avec en paramètre la nouvelle compétence
        $form->handleRequest($request); // gestionnaire de requêtes HTTP

        if ($form->isSubmitted()){ // vérifie si le formulaire a été envoyé
            if ($form->isValid()){ // vérifie si le formulaire est valide
                
                $infoImg = $form['img']->getData();// récupère les informations du champ img du formulaire
                $extensionImg = $infoImg->guessExtension();// récupère l'extension de fichier (png, jpeg, ...)
                $nomImg = time() .'.'. $extensionImg;// reconstitue un nom d'img unique

                $infoImg->move($this->getParameter('dossier_img_competences'), $nomImg);

                $competence->setImg($nomImg); // définit le nom de l'img qui sera mis en bdd
                
                /* Pour visualiser (console.log)
                echo '<pre>'; 
                var_dump($nomImg);
                echo '</pre>';
                die;*/

                $manager = $this->getDoctrine()->getManager(); // récupère le gestionnaire de doctrine
                $manager->persist($competence);// je rajoute la competence par Doctrine remplie en ligne 32
                $manager->flush();//j'envoie en BDD la requête
                //message de succès
                return $this->redirectToRoute('competences');
            }else{

                // formulaire non valide
                // message d'erreur
            }
        }
      
        //gestion des données

        return $this->render('admin/competenceForm.html.twig', [
            'competenceForm'=>$form->createView() // création de la vue du formulaire (et envoie le fichier à la vue)
        ]);
    }

    #[Route('/admin/competences/delete-{id}', name:'delete_competence')] // on met l'id dans la route car ce sera l'objet de la recherche
    public function deleteCompetence(CompetenceRepository $competenceRepository, int $id)
    {
        $competence=$competenceRepository->find($id);

        $nomImg =$competence->getImg(); // récupère le nom de l'image
        $cheminImg = $this->getParameter('dossier_img_competences') .'/'. $nomImg; // reconstitue le chemin du fichier
        unlink($cheminImg);// fonction unlink() pour la suppression de l'image dans le répertoire


        $manager= $this->getDoctrine()->getManager();// récupère le gestionnaire de doctrine
        $manager->remove($competence);// je rajoute la competence par Doctrine remplie en ligne 32
        $manager->flush();//j'envoie la requête en BDD
        //message de succès 
        return $this->redirectToRoute('competences');       
    }
}
