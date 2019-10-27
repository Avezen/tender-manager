<?php

namespace App\Repository;

use App\Entity\ProductProductColumn;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductProductColumn|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductProductColumn|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductProductColumn[]    findAll()
 * @method ProductProductColumn[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductProductColumnRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductProductColumn::class);
    }

    // /**
    //  * @return ProductProductColumn[] Returns an array of ProductProductColumn objects
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
    public function findOneBySomeField($value): ?ProductProductColumn
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
