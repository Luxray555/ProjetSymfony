<?php

namespace App\Repository;

use App\Entity\Anime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Anime>
 *
 * @method Anime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anime[]    findAll()
 * @method Anime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anime::class);
    }

    /**
     * @return Anime[] Returns an array of Anime objects
     */
    public function findNewlyAdded(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.dateAjout', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Anime[] Returns an array of Anime objects
     */
    public function findTrendingAnime(): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
            ;
    }

    public function search(?string $nom, ?array $genres, ?array $status): array
    {
        $queryBuilder = $this->createQueryBuilder('a');

        if (!empty($nom)) {
            $queryBuilder->andWhere('a.nom LIKE :nom')
                ->setParameter('nom', '%' . $nom . '%');
        }

        if ($genres !== [""]) {
            $queryBuilder
                ->leftJoin('a.genres', 'g')
                ->andWhere('g.nom IN (:genres)')
                ->setParameter('genres', $genres);
        }

        if ($status !== [""]) {
            $queryBuilder
                ->leftJoin('a.status', 's')
                ->andWhere('s.nom IN (:status)')
                ->setParameter('status', $status);
        }

        $queryBuilder->orderBy('a.nom', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }

//    public function findOneBySomeField($value): ?Anime
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
