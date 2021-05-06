<?php

namespace App\Form;

use App\Entity\Competence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CompetenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categorie', ChoiceType::class,//sécurisation par la catégorie (ChoiceType::class)
            [ 'choices' => [
                '- choisir une catégorie -'=>'',
                'bibliothèque' => 'bibliothèque',
                'CMS' => 'CMS',
                'framework' => 'framework',
                'technologie' => 'technologie',
                'autre' => 'soft skill'
            ]
            ])
            ->add('titre', TextType::class, [//sécurisation par la catégorie (TextType::class)
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex. : HTML'
                ]
            ])
            ->add('img', FileType::class, [//sécurisation par la catégorie (FileType::class)
                'required'=> false,// pour ne pas avoir de souci au moment de la modif.
                'mapped' => false, //dissosiation du champ image d'une chaîne de caractère (dans la BDD)
                'help' => 'png, jpg, jpeg ou jp2 - 1 Mo maximum',//message d'information de taille
                'constraints' => [
                    new Image([//contraintes de type de fichier
                        'maxSize' => '1024k',
                        'maxSizeMessage' => 'L\image choisie est trop volumineuse',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                            'image/jp2'
                        ],
                        'mimeTypesMessage' => 'Merci de sélectionner une image au format PNG, JPG, JPEG ou JP2'
                    ])


                ]

            ])

            //comme on va créer un bouton annuler on va le faire dans competenceForm
            // ->add('validation', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Competence::class,
        ]);
    }
}
