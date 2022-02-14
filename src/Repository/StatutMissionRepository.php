<?php

namespace App\Repository;

use App\Entity\StatutMission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StatutMission|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutMission|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutMission[]    findAll()
 * @method StatutMission[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutMissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutMission::class);
    }
}