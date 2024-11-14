<?php

namespace App\Form;

use App\Entity\EtatExemplaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutEtatExemplaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etatExemplaire', TextType::class, [
                'label' => "Nom de l'état exemplaire",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom de l'état exemplaire",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EtatExemplaire::class,
        ]);
    }
}
