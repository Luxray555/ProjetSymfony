<?php

namespace App\Repository;

use App\Entity\ReponseTicket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ReponseTicket>
 *
 * @method ReponseTicket|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReponseTicket|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReponseTicket[]    findAll()
 * @method ReponseTicket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReponseTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReponseTicket::class);
    }

//    /**
//     * @return ReponseTicket[] Returns an array of ReponseTicket objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ReponseTicket
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
