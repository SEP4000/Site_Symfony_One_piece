<?php

namespace App\Repository;

use App\Entity\Arc;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Arc>
 *
 * @method Arc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arc[]    findAll()
 * @method Arc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arc::class);
    }

    public function save(Arc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Arc $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    
    public function paginationQuery()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
        ;
   }

//    public function findOneBySomeField($value): ?Arc
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
