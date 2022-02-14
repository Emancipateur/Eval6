<?php

namespace App\Repository;

use App\Entity\Planque;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Planque|null find($id, $lockMode = null, $lockVersion = null)
 * @method Planque|null findOneBy(array $criteria, array $orderBy = null)
 * @method Planque[]    findAll()
 * @method Planque[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlanqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Planque::class);
    }

    // /**
    //  * @return Planque[] Returns an array of Planque objects
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
    public function findOneBySomeField($value): ?Planque
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
