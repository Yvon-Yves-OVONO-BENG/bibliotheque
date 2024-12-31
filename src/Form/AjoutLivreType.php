<?php

namespace App\Form;

use App\Entity\Face;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Langue;
use App\Entity\Armoire;
use App\Entity\Editeur;
use App\Entity\Fournisseur;
use App\Entity\StatutLivre;
use App\Entity\GenreLitteraire;
use App\Repository\FaceRepository;
use App\Repository\AuteurRepository;
use App\Repository\LangueRepository;
use App\Repository\ArmoireRepository;
use App\Repository\EditeurRepository;
use Symfony\Component\Form\AbstractType;
use App\Repository\FournisseurRepository;
use App\Repository\StatutLivreRepository;
use App\Repository\GenreLitteraireRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AjoutLivreType extends AbstractType
{
    public function __construct(protected TranslatorInterface $translator)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => $this->translator->trans('Titre du livre'), 
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => $this->translator->trans("Saisir le titre du livre"),
                ]
            ])
            ->add('isbn', TextType::class, [
                'label' => $this->translator->trans("ISBN"), 
                'attr' => [
                    'placeholder' => $this->translator->trans("Saisir l'ISBN"),
                ] 
            ])
            ->add('datePublicationAt', DateType::class, [
                'label' => $this->translator->trans("Date de publication"),
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => $this->translator->trans("Saisir la date de publication"),
                ]
            ])
            ->add('nombreExemplaire', IntegerType::class, [
                'label' => $this->translator->trans("Nombre d'exemplaires"),
                'attr' => [
                    'placeholder' => $this->translator->trans("Saisir le nombre d'exemplaires"),
                ] 
            ])
            ->add('resume', TextareaType::class, [
                'label' => $this->translator->trans("Résumé du livre"), 
                'attr' => [
                    'placeholder' => $this->translator->trans("Saisir le résumé du livre"),
                    'rows' => 12
                ]
            ])
           
            // ->add('slug')
            ->add('niveau', IntegerType::class, [
                'label' => $this->translator->trans("Niveau"), 
                'attr' => [
                    'placeholder' => $this->translator->trans("Saisir le niveau de l'étagère"),
                ]
            ])
            ->add('genreLitteraire', EntityType::class, [
                'class' => GenreLitteraire::class,
                'choice_label' => 'genreLitteraire',
                'required' => true,
                'placeholder' => 'Choisir le genre litteraire',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(GenreLitteraireRepository $genreLitteraireRepository){
                    return $genreLitteraireRepository->createQueryBuilder('g')->orderBy('g.genreLitteraire'); 
                },
            ])
            ->add('auteur', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'nom',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(AuteurRepository $auteurRepository){
                    return $auteurRepository->createQueryBuilder('a')->orderBy('a.nom');
                },
            ])
            ->add('editeur', EntityType::class, [
                'class' => Editeur::class,
                'choice_label' => 'editeur',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(EditeurRepository $editeurRepository){
                    return $editeurRepository->createQueryBuilder('e')->orderBy('e.editeur'); 
                },
            ])
            ->add('langue', EntityType::class, [
                'class' => Langue::class,
                'choice_label' => 'langue',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(LangueRepository $langueRepository){
                    return $langueRepository->createQueryBuilder('l')->orderBy('l.langue');  
                },
            ])
            ->add('statutLivre', EntityType::class, [
                'class' => StatutLivre::class,
                'choice_label' => 'statutLivre',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(StatutLivreRepository $statutLivreRepository){
                    return $statutLivreRepository->createQueryBuilder('s')->orderBy('s.statutLivre');  
                },
            ])
            ->add('fournisseur', EntityType::class, [
                'class' => Fournisseur::class,
                'choice_label' => 'nom',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(FournisseurRepository $fournisseurRepository){
                    return $fournisseurRepository->createQueryBuilder('f')->orderBy('f.nom');  
                },
            ])
            ->add('armoire', EntityType::class, [
                'class' => Armoire::class,
                'choice_label' => 'armoire',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(ArmoireRepository $armoireRepository){
                    return $armoireRepository->createQueryBuilder('a')->orderBy('a.armoire');  
                },
            ])
            ->add('face', EntityType::class, [
                'class' => Face::class,
                'choice_label' => 'face',
                'required' => true,
                'placeholder' => '- - -',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(FaceRepository $faceRepository){
                    return $faceRepository->createQueryBuilder('f')->orderBy('f.face');  
                },
            ])

            ->add('photos', FileType::class, [
                'label' => $this->translator->trans('Autres photos du livre'),
                'multiple' => true,
                'mapped' => false,
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'dropify',
                    'data-height' => '180'
                ]

            ])
            
            ->add('photo', FileType::class, [
                'label' => $this->translator->trans('Première de couverture'),
                'multiple' => false,
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'dropify',
                    'data-height' => '180'
                ]

            ])
            ->add('montantEmprunt', NumberType::class, [
                'label' => "Montant de l'emprunt",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le montant de l'emprunt",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
