<?php

namespace App\Repository\Gx;

use App\Entity\Gx\ScheduledClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ScheduledClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScheduledClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScheduledClass[]    findAll()
 * @method ScheduledClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduledClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ScheduledClass::class);
    }

    // /**
    //  * @return ScheduledClass[] Returns an array of ScheduledClass objects
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

    public function findAllScheduledClassesByDay($day)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.dayOfWeek = :day')
            ->setParameter('day', $day)
            ->orderBy('s.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllScheduledClassesByDate($date, $day)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.startDate <= :date')
            ->andWhere('s.dayOfWeek = :day')
            ->setParameters(array(
                'date' => $date,
                'day' => $day))
            ->orderBy('s.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllScheduledClassesByLocation($id)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.location = :id')
            ->setParameter('id', $id)
            ->orderBy('s.startTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?ScheduledClass
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
