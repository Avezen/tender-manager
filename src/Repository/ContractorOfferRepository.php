<?php

namespace App\Repository;

use App\Entity\ContractorOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ContractorOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContractorOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContractorOffer[]    findAll()
 * @method ContractorOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContractorOfferRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ContractorOffer::class);
    }

    // /**
    //  * @return ContractorOffer[] Returns an array of ContractorOffer objects
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
    public function findOneBySomeField($value): ?ContractorOffer
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
