<?php

namespace App\Repository;

use App\Entity\ContractorOfferProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContractorOfferProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractorOfferProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractorOfferProduct[]    findAll()
 * @method ContractorOfferProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractorOfferProductRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContractorOfferProduct::class);
    }

    // /**
    //  * @return ContractorOfferProduct[] Returns an array of ContractorOfferProduct objects
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
    public function findOneBySomeField($value): ?ContractorOfferProduct
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
