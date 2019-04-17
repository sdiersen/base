<?php

namespace App\Repository\Gx;

use App\Entity\Gx\GxClass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GxClass|null find($id, $lockMode = null, $lockVersion = null)
 * @method GxClass|null findOneBy(array $criteria, array $orderBy = null)
 * @method GxClass[]    findAll()
 * @method GxClass[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GxClassRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GxClass::class);
    }

    // /**
    //  * @return GxClass[] Returns an array of GxClass objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function getAllLongClassNames()
    {
        return $this->createQueryBuilder('g')
            ->select('g.name')
            ->orderBy('g.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function getAllShortClassNames()
    {
        return $this->createQueryBuilder('g')
            ->select('g.shortName')
            ->orderBy('g.shortName', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?GxClass
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByShortName($shortName): ?GxClass
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.shortName = :name')
            ->setParameter('name', $shortName)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
