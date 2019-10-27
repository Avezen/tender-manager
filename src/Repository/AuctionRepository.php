<?php

namespace App\Repository;

use App\Constants\AuctionStatus;
use App\Entity\Auction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Auction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auction[]    findAll()
 * @method Auction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuctionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Auction::class);
    }

    // /**
    //  * @return Auction[] Returns an array of Auction objects
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


    public function findActiveAuctions(
        $activeStatus = AuctionStatus::IN_PROGRESS,
        $finishedStatus = AuctionStatus::FINISHED_EMPTY
    ): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status >= :active')
            ->andWhere('a.status < :finished')
            ->setParameter('active', $activeStatus)
            ->setParameter('finished', $finishedStatus)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDraftAuctions($activeStatus = AuctionStatus::IN_PROGRESS): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status < :val')
            ->setParameter('val', $activeStatus)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findFinishedAuctions($finishedStatus = AuctionStatus::FINISHED_EMPTY): ?array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.status >= :val')
            ->setParameter('val', $finishedStatus)
            ->getQuery()
            ->getResult()
            ;
    }

}
