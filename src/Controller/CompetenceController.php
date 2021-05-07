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
    /***************************CREATION DU FORMULAIRE*********************************/
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
                $this->addFlash('success', 'La compétence a bien été ajoutée');
                return $this->redirectToRoute('competences');
            }else{
                        // message d'erreur
                $this->addFlash('danger', 'Une erreur est survenue lors de la création de la compétence !');

                // formulaire non valide
        
            }
        }
      
        //gestion des données

        return $this->render('admin/competenceForm.html.twig', [
            'competenceForm'=>$form->createView() // création de la vue du formulaire (et envoie le fichier à la vue)
        ]);


    }
    /***************************MODIFICATION DU FORMULAIRE*********************************/
    #[Route('/admin/competences/update-{id}', name:'update_competence')] // on met l'id dans la route car ce sera l'objet de la recherche
    public function deleteCompetence(CompetenceRepository $competenceRepository, int $id, Request $request)
    {
        $competence=$competenceRepository->find($id);
        $form = $this->createForm(CompetenceType::class, $competence); // ATTENTION : création d'un formulaire mais pas une compétence
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){ // vérifie si le formulaire a été envoyé && vérifie si le formulaire est valide
            /*
                - vérifier si l'image est présente sur le formulaire
                    - oui : supprimer l'ancienne : récupère le nom, reconstitue son chemin, unlink
                    - ajouter la nouvelle : générer un nom (time), move, setImg()
                    - non : on ne fait rien
                - envoyer les nouvelles données en bdd :
                    - persist
                    - flush
            */
            $infoImg=$form['img']->getData();
            if ($infoImg !== null){
                //die("il y a bien une image");
                if (file_exists($this->getParameter('dossier_img_competences').'/'. $competence->getImg())){
                unlink($this->getParameter('dossier_img_competences').'/'. $competence->getImg());//identique au unlink suppression mais condensé
                }
                $nomImg=time().'.'.$infoImg->guessExtension();
                $infoImg->move($this->getParameter('dossier_img_competences'), $nomImg);
                $competence->setImg($nomImg);
            }

            $manager= $this->getDoctrine()->getManager();// récupère le gestionnaire de doctrine
            $manager->persist($competence);// je rajoute la competence par Doctrine remplie en ligne 32
            $manager->flush();//j'envoie la requête en BDD
            //message de succès 
            $this->addFlash('success', 'La compétence a bien été modifiée');
            return $this->redirectToRoute('competences');


        }
        return $this->render('admin/competenceForm.html.twig', [
            'competenceForm'=>$form->createView() // création de la vue du formulaire (et envoie le fichier à la vue)
        ]);
    }

/****************************************SUPPRESSION*************************************/

    #[Route('/admin/competences/delete-{id}', name:'delete_competence')] // on met l'id dans la route car ce sera l'objet de la recherche
    public function updateCompetence(CompetenceRepository $competenceRepository, int $id)
    {
        $competence=$competenceRepository->find($id);

        $nomImg =$competence->getImg(); // récupère le nom de l'image
        $cheminImg = $this->getParameter('dossier_img_competences') .'/'. $nomImg; // reconstitue le chemin du fichier
        unlink($cheminImg);// fonction unlink() pour la suppression de l'image dans le répertoire


        $manager= $this->getDoctrine()->getManager();// récupère le gestionnaire de doctrine
        $manager->remove($competence);// je rajoute la competence par Doctrine remplie en ligne 32
        $manager->flush();//j'envoie la requête en BDD
        //message de succès 
        $this->addFlash('success', 'La compétence a bien été suprimée');
        return $this->redirectToRoute('competences');       
    }

    
}
