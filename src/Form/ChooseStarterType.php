<?php

namespace App\Form;

use App\Entity\Bot;
use App\Entity\User;
use App\Entity\Attack;
use App\Entity\Equipe;
use App\Entity\Pokemon;
use App\Repository\PokemonRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChooseStarterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('trainer', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
            ])
            ->add('pokemonId', EntityType::class, [
                'class' => Pokemon::class,
                'label' => 'Pokemon',
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'choices'  => [
                    'Tortipousse' => function(PokemonRepository $pokemonRepository){ $pokemonRepository->findOneBy(['id' => 1]); } ,
                    'Ouisticram' => function(PokemonRepository $pokemonRepository){ $pokemonRepository->findOneBy(['id' => 2]); },
                    'Tiplouf' => function(PokemonRepository $pokemonRepository){ $pokemonRepository->findOneBy(['id' => 3]); }, 
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipe::class,
        ]);
    }
}
