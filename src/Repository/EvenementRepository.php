<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }

    //    /**
    //     * @return Evenement[] Returns an array of Evenement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Evenement
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function countUpcoming(): int
    {
        return (int) $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')
            ->where('e.dateEvenement >= :now')
            ->andWhere('e.statutEvenement != :annule')
            ->setParameter('now', new \DateTime())
            ->setParameter('annule', 'annule')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @return Evenement[]
     */
    public function findUpcoming(int $limit = 10): array
    {
        return $this->createQueryBuilder('e')
            ->where('e.dateEvenement >= :now')
            ->andWhere('e.statutEvenement != :annule')
            ->setParameter('now', new \DateTime())
            ->setParameter('annule', 'annule')
            ->orderBy('e.dateEvenement', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
