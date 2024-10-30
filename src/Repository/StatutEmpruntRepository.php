<?php

namespace App\Repository;

use App\Entity\StatutEmprunt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StatutEmprunt>
 *
 * @method StatutEmprunt|null find($id, $lockMode = null, $lockVersion = null)
 * @method StatutEmprunt|null findOneBy(array $criteria, array $orderBy = null)
 * @method StatutEmprunt[]    findAll()
 * @method StatutEmprunt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StatutEmpruntRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StatutEmprunt::class);
    }

    public function save(StatutEmprunt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(StatutEmprunt $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return StatutEmprunt[] Returns an array of StatutEmprunt objects
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

//    public function findOneBySomeField($value): ?StatutEmprunt
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
