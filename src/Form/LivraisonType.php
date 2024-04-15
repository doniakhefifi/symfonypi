<?php

namespace App\Form;

use App\Entity\Livraison;
use App\Entity\Livreur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivraisonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('clientName')
            ->add('deliveryAdress')
            ->add('deliveryDate')
            ->add('status')
            ->add('commande')
            ->add('livreur', EntityType::class, [
                'class' => Livreur::class,
                'choice_label' => 'livreurName',
                'placeholder' => 'Select a Livreur',
                'required' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livraison::class,
        ]);
    }
}
