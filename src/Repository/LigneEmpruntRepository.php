<?php

namespace App\Repository;

use App\Entity\LigneEmprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneEmprunt>
 *
 * @method LigneEmprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneEmprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneEmprunt[]    findAll()
 * @method LigneEmprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneEmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneEmprunt::class);
    }

//    /**
//     * @return LigneEmprunt[] Returns an array of LigneEmprunt objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LigneEmprunt
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
