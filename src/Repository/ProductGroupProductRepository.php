<?php

namespace App\Repository;

use App\Entity\ProductGroupProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductGroupProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductGroupProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductGroupProduct[]    findAll()
 * @method ProductGroupProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductGroupProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductGroupProduct::class);
    }

    // /**
    //  * @return ProductGroupProduct[] Returns an array of ProductGroupProduct objects
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
    public function findOneBySomeField($value): ?ProductGroupProduct
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
