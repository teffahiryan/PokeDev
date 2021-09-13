<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Equipe;
use App\Entity\Pokemon;
use App\Entity\CatchPokemon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CatchPokemonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userId', EntityType::class,[
                'class' => User::class,
                'choice_label' => 'id',
            ])
            ->add('equipeId', EntityType::class,[
                'class' => Equipe::class,
                'choice_label' => 'id',
            ])
            ->add('pokemonId', EntityType::class,[
                'class' => Pokemon::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CatchPokemon::class,
        ]);
    }
}
