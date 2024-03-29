<?php

namespace App\Form;

use App\Entity\Pokemon;
use App\Entity\CatchPokemon;
use Doctrine\ORM\EntityRepository;
use App\Controller\PokemonController;
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
            ->add('pokemonId', EntityType::class,[
                'class' => Pokemon::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')->where('p.id IN(1,2,3)');
                },
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
