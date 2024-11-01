<?php

namespace App\Form;

use App\Entity\Armoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AjoutArmoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('armoire', TextType::class, [
                'label' => 'Nom armoire',
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nom de l'armoire",
                ]
            ])
            ->add('nombreEtagere', IntegerType::class, [
                'label' => "Nombre d'étagère",
                'attr' => [
                    'autofocus' => true,
                    'placeholder' => "Saisir le nombre d'étagère",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Armoire::class,
        ]);
    }
}
