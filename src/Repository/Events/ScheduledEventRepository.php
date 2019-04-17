<?php

namespace App\Repository\Events;

use App\Entity\Events\ScheduledEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScheduledEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduledEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduledEvent[]    findAll()
 * @method ScheduledEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduledEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScheduledEvent::class);
    }

    // /**
    //  * @return ScheduledEvent[] Returns an array of ScheduledEvent objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ScheduledEvent
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
