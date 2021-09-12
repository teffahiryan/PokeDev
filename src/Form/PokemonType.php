<?php

namespace App\Form;

use App\Entity\Attack;
use App\Entity\Type;
use App\Entity\Pokemon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('hp')
            ->add('idType', EntityType::class, [
                'class' => Type::class,
                'label' => 'Type',
                'multiple' => 'true',
                'choice_label' => 'name',
                'expanded' => true
            ])
            ->add('attack', EntityType::class, [
                'class' => Attack::class,
                'label' => 'Attaque',
                'multiple' => 'true',
                'choice_label' => 'name',
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pokemon::class,
        ]);
    }
}
