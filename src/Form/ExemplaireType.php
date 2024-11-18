<?php

namespace App\Form;

use App\Entity\EtatExemplaire;
use App\Entity\Exemplaire;
use App\Entity\Livre;
use App\Repository\EtatExemplaireRepository;
use App\Repository\ExemplaireRepository;
use App\Repository\LivreRepository;
use DateTime;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExemplaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateAcquisitionAt', DateType::class, [
                'label' => "Date d'acquisition", 
                'widget' =>'single_text',
            ])
            ->add('codeExemplaire', TextType::class, [
                'label' => "Code de l'exemplaire"
            ])
            // ->add('slug')
            ->add('livre', EntityType::class, [
                'label' => 'Livre',
                'class' => Livre::class,
                'choice_label' => 'titre',
                'placeholder' => 'Choisir le livre',
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(LivreRepository $livreRepository){
                    return $livreRepository->createQueryBuilder('l')->orderBy('l.titre'); 
                },
            ])
            ->add('etatExemplaire', EntityType::class, [
                'label' => 'Etat du livre', 
                'class' => EtatExemplaire::class, 
                'choice_label' => 'etatExemplaire',
                'placeholder' => "Choisir l'état du livre",
                'attr' => [
                    'class' => 'form-control select2-show-search',
                ],
                'query_builder' => function(EtatExemplaireRepository $etatExemplaireRepository){
                    return $etatExemplaireRepository->createQueryBuilder('e')->orderBy('e.etatExemplaire'); 
                },
            ])
            // ->add('membre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exemplaire::class,
        ]);
    }
}
