<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $competence1 = new Competence(); // nouvelle instance de la classe Competence (crée un nouvel objet Competence)
        $competence1->setCategorie('technologie'); // définit l'attribut categorie
        $competence1->setTitre('HTML'); // définit l'attribut titre
        $competence1->setImg('html.png'); // définit l'attribut img
        $manager->persist($competence1); // précise que l'on va peut-être envoyé l'objet en bdd

        $competence2 = new Competence();
        $competence2->setCategorie('technologie');
        $competence2->setTitre('CSS');
        $competence2->setImg('css.png');
        $manager->persist($competence2);

        $competence3 = new Competence();
        $competence3->setCategorie('framework');
        $competence3->setTitre('Symfony');
        $competence3->setImg('symfony.png');
        $manager->persist($competence3);

        $competence4 = new Competence();
        $competence4->setCategorie('bibliothèque');
        $competence4->setTitre('Bootstrap');
        $competence4->setImg('bootstrap.png');
        $manager->persist($competence4);

        $competence5 = new Competence();
        $competence5->setCategorie('CMS');
        $competence5->setTitre('WordPress');
        $competence5->setImg('wordpress.png');
        $manager->persist($competence5);

        $competence6 = new Competence();
        $competence6->setCategorie('CMS');
        $competence6->setTitre('PrestaShop');
        $competence6->setImg('prestashop.png');
        $manager->persist($competence6);

        $manager->flush();
    }
}
