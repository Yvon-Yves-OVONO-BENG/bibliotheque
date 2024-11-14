<?php

namespace App\Form;

use App\Entity\EtatPaiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutEtatPaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etatPaiement', TextType::class, [
                'label' => "Nom de l'état paiement",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom de l'état paiement",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtatPaiement::class,
        ]);
    }
}
