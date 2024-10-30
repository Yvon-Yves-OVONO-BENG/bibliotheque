<?php

namespace App\Repository;

use App\Entity\NoteEtoileLivre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NoteEtoileLivre>
 *
 * @method NoteEtoileLivre|null find($id, $lockMode = null, $lockVersion = null)
 * @method NoteEtoileLivre|null findOneBy(array $criteria, array $orderBy = null)
 * @method NoteEtoileLivre[]    findAll()
 * @method NoteEtoileLivre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoteEtoileLivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NoteEtoileLivre::class);
    }

    public function save(NoteEtoileLivre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(NoteEtoileLivre $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return NoteEtoileLivre[] Returns an array of NoteEtoileLivre objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('n.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?NoteEtoileLivre
//    {
//        return $this->createQueryBuilder('n')
//            ->andWhere('n.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
