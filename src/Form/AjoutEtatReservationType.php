<?php

namespace App\Form;

use App\Entity\EtatReservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutEtatReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etatReservation', TextType::class, [
                'label' => "Nom de l'état réservation",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom de l'état réservation",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtatReservation::class,
        ]);
    }
}
