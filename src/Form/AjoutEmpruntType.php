<?php

namespace App\Form;

use App\Entity\Membre;
use App\Entity\Emprunt;
use App\Entity\EtatPaiement;
use App\Entity\ModePaiement;
use App\Entity\StatutEmprunt;
use App\Repository\MembreRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\EtatPaiementRepository;
use App\Repository\ModePaiementRepository;
use App\Repository\StatutEmpruntRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AjoutEmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('membre', EntityType::class, [
                'class' => Membre::class,
                'choice_label' => 'nom',
                'required' => true,
                'placeholder' => 'Sélectionner le membre',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(MembreRepository $membreRepository){
                    return $membreRepository->createQueryBuilder('m')->orderBy('m.nom'); 
                },
            ])
           
            ->add('statutEmprunt', EntityType::class, [
                'class' => StatutEmprunt::class,
                'choice_label' => 'statutEmprunt',
                'required' => true,
                'placeholder' => "Sélectionner le statut de l'emprunt",
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(StatutEmpruntRepository $statutEmpruntRepository){
                    return $statutEmpruntRepository->createQueryBuilder('s')->orderBy('s.statutEmprunt'); 
                },
            ])
            ->add('modePaiement', EntityType::class, [
                'class' => ModePaiement::class,
                'choice_label' => 'modePaiement',
                'required' => true,
                'placeholder' => "Sélectionner le statut de l'emprunt",
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(ModePaiementRepository $modePaiementRepository){
                    return $modePaiementRepository->createQueryBuilder('m')->orderBy('m.modePaiement'); 
                },
            ])
            ->add('etatPaiement', EntityType::class, [
                'class' => EtatPaiement::class,
                'choice_label' => 'etatPaiement',
                'required' => true,
                'placeholder' => "Sélectionner l'état paiment",
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(EtatPaiementRepository $etatPaiementRepository){
                    return $etatPaiementRepository->createQueryBuilder('e')->orderBy('e.etatPaiement'); 
                },
            ])

            ->add('ligneEmprunts', CollectionType::class, [
                'label' => false,
                'entry_type' => LigneEmpruntType::class,
                'entry_options' => [
                    'label' => false
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'collection-container d-flex',
                ],
            ]);
    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);

    }
}
