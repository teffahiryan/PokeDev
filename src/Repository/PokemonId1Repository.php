<?php

namespace App\Repository;

use App\Entity\PokemonId1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PokemonId1|null find($id, $lockMode = null, $lockVersion = null)
 * @method PokemonId1|null findOneBy(array $criteria, array $orderBy = null)
 * @method PokemonId1[]    findAll()
 * @method PokemonId1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PokemonId1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PokemonId1::class);
    }

    // /**
    //  * @return PokemonId1[] Returns an array of PokemonId1 objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PokemonId1
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
