<?php

namespace App\Repository\Swim;

use App\Entity\Swim\ScheduledLesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScheduledLesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduledLesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduledLesson[]    findAll()
 * @method ScheduledLesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduledLessonRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScheduledLesson::class);
    }

    // /**
    //  * @return ScheduledLesson[] Returns an array of ScheduledLesson objects
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
    public function findOneBySomeField($value): ?ScheduledLesson
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
