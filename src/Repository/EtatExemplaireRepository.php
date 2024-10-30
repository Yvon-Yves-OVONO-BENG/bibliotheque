<?php

namespace App\Repository;

use App\Entity\EtatExemplaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EtatExemplaire>
 *
 * @method EtatExemplaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method EtatExemplaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method EtatExemplaire[]    findAll()
 * @method EtatExemplaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtatExemplaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EtatExemplaire::class);
    }

    public function save(EtatExemplaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(EtatExemplaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return EtatExemplaire[] Returns an array of EtatExemplaire objects
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

//    public function findOneBySomeField($value): ?EtatExemplaire
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
