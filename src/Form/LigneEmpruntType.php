<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\LigneEmprunt;
use App\Repository\LivreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class LigneEmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'titre',
                'required' => true,
                'placeholder' => 'Choisir le livre',
                'attr' => [
                    'data-url' => '/montant-livre', // Base URL pour récupérer le montant,
                    'class' => 'livre-selector form-select form-control select2-show-search',
                ],
                'query_builder' => function(LivreRepository $livreRepository){
                    return $livreRepository->createQueryBuilder('l')->orderBy('l.titre'); 
                },
                'choice_attr' => function(Livre $livre) {
                    return ['data-montant' => $livre->getMontantEmprunt()];
                },
            ])
            
            ->add('quantite', NumberType::class, [
                'label' => "Quantité",
                'attr' => [
                    'autofocus' => true,
                    'class' => 'form-control',
                    'placeholder' => "Saisir la quantité",
                ]
            ])
            ->add('dateRetourPrevueAt', DateType::class, [
                'label' => 'Date de retour prévue',
                'widget' => 'single_text',
                'attr' => [ 
                    'class' => 'form-control',
                ]
            ])
            ->add('montant', NumberType::class, [
                'label' => 'Montant',
                'attr' => [ 
                    'readonly' => true,
                    'placeholder' => "Montant emprunt du livre",
                    'class' => 'montant-field form-control',
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneEmprunt::class,
        ]);

    }
}
