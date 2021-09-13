<?php

namespace App\Repository;

use App\Entity\CatchPokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CatchPokemon|null find($id, $lockMode = null, $lockVersion = null)
 * @method CatchPokemon|null findOneBy(array $criteria, array $orderBy = null)
 * @method CatchPokemon[]    findAll()
 * @method CatchPokemon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CatchPokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CatchPokemon::class);
    }

    // /**
    //  * @return CatchPokemon[] Returns an array of CatchPokemon objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CatchPokemon
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
