<?php

namespace App\Repository;

use App\Entity\SubItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SubItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubItem[]    findAll()
 * @method SubItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubItemRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SubItem::class);
    }

//    /**
//     * @return SubItem[] Returns an array of SubItem objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubItem
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
