<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Nationalite;
use App\Entity\Sexe;
use App\Entity\TypeAuteur;
use App\Repository\NationaliteRepository;
use App\Repository\SexeRepository;
use App\Repository\TypeAuteurRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AjoutAuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom de l'auteur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom de l'auteur",
                ]
            ])
            ->add('dateNaissanceAt', DateType::class, [
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('biographie', TextareaType::class, [
                'label' => "Biographie de l'auteur",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir la biographie de l'auteur",
                ]
            ])
            ->add('nationalite', EntityType::class, [
                'class' => Nationalite::class,
                'choice_label' => 'nationalite',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(NationaliteRepository $nationaliteRepository){
                    
                    return $nationaliteRepository->createQueryBuilder('n')->orderBy('n.nationalite');
                    
                },
            ])
            ->add('sexe', EntityType::class, [
                'class' => Sexe::class,
                'choice_label' => 'sexe',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(SexeRepository $sexeRepository){
                    
                    return $sexeRepository->createQueryBuilder('s')->orderBy('s.sexe');
                    
                },
            ])
            ->add('typeAuteur', EntityType::class, [
                'class' => TypeAuteur::class,
                'choice_label' => 'typeAuteur',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(TypeAuteurRepository $typeAuteurRepository){
                    
                    return $typeAuteurRepository->createQueryBuilder('t')->orderBy('t.typeAuteur');
                    
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
