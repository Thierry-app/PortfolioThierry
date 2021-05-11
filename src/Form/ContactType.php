<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('email', EmailType::class)
            ->add('objet', ChoiceType::class, [
                'choices' => [
                    '- choix -' => '',
                    'demande de renseignements' => 'renseignements',
                    'proposer un mission' => 'proposition',
                    'signaler un problème' => 'problème'
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'min' => 50,
                    'max' => 1000,
                    'rows' => 5
                ],
                'help' => '1000 caractères maximum'
            ])
            ->add('envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}