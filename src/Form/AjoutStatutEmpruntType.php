<?php

namespace App\Form;

use App\Entity\StatutEmprunt;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutStatutEmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statutEmprunt', TextType::class, [
                'label' => "Nom du statut emprunt",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom du statut emprunt",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StatutEmprunt::class,
        ]);
    }
}
