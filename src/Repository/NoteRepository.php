<?php

namespace App\Repository;

use App\Entity\Anime;
use App\Entity\Note;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Note>
 *
 * @method Note|null find($id, $lockMode = null, $lockVersion = null)
 * @method Note|null findOneBy(array $criteria, array $orderBy = null)
 * @method Note[]    findAll()
 * @method Note[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Note::class);
    }

    /**
     * @return Note[] Returns an array of Note objects
     */
    public function findLastNotesForUser($user): array
    {

        return $this->createQueryBuilder('n')
            ->andWhere('n.user = :user')
            ->setParameter('user', $user)
            ->orderBy('n.dateCreation', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }

    public function updateNote(Note $note, User $user, Anime $anime): bool
    {

        return $this->createQueryBuilder('n')->update('App:Note', 'n')
            ->set('n.note', ':note')
            ->where('n.anime = :anime')
            ->andWhere('n.user = :user')
            ->setParameter('note', $note->getNote())
            ->setParameter('anime', $anime)
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }

//    public function findOneBySomeField($value): ?Note
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
