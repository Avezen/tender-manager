<?php

namespace App\Repository;

use App\Entity\AuctionFormField;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AuctionFormField|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuctionFormField|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuctionFormField[]    findAll()
 * @method AuctionFormField[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionFormFieldRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AuctionFormField::class);
    }

    // /**
    //  * @return AuctionFormField[] Returns an array of AuctionFormField objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AuctionFormField
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
