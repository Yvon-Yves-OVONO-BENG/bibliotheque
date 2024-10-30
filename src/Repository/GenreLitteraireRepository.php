<?php

namespace App\Repository;

use App\Entity\GenreLitteraire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<GenreLitteraire>
 *
 * @method GenreLitteraire|null find($id, $lockMode = null, $lockVersion = null)
 * @method GenreLitteraire|null findOneBy(array $criteria, array $orderBy = null)
 * @method GenreLitteraire[]    findAll()
 * @method GenreLitteraire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreLitteraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GenreLitteraire::class);
    }

    public function save(GenreLitteraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(GenreLitteraire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return GenreLitteraire[] Returns an array of GenreLitteraire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?GenreLitteraire
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
