<?php

namespace App\Repository;

use App\Entity\Sondage;
use App\Entity\Utilisateur;
use App\Entity\Vote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vote>
 */
class VoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    public function save(Vote $vote, bool $flush = false): void
    {
        $this->getEntityManager()->persist($vote);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Checks if a user has already voted for a specific sondage.
     *
     * @param Utilisateur $user
     * @param Sondage $sondage
     * @return bool
     */
    public function hasUserVoted(Utilisateur $user, Sondage $sondage): bool
    {
        $vote = $this->createQueryBuilder('v')
            ->andWhere('v.user = :user')
            ->andWhere('v.sondage = :sondage')
            ->setParameter('user', $user)
            ->setParameter('sondage', $sondage)
            ->getQuery()
            ->getOneOrNullResult();

        return $vote !== null;
    }

    //    /**
    //     * @return Vote[] Returns an array of Vote objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('v.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Vote
    //    {
    //        return $this->createQueryBuilder('v')
    //            ->andWhere('v.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
