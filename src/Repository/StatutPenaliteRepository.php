<?php

namespace App\Repository;

use App\Entity\StatutPenalite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatutPenalite>
 *
 * @method StatutPenalite|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutPenalite|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutPenalite[]    findAll()
 * @method StatutPenalite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutPenaliteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutPenalite::class);
    }

    public function save(StatutPenalite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatutPenalite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StatutPenalite[] Returns an array of StatutPenalite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StatutPenalite
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
