<?php

// src/Repository/TransactionRepository.php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    public function findBySearchCriteria($category, $type, $startDate, $endDate)
    {
        $queryBuilder = $this->createQueryBuilder('t');

        if ($category) {
            $queryBuilder->andWhere('t.categTra = :category')
                ->setParameter('category', $category);
        }

        if ($type) {
            $queryBuilder->andWhere('t.typeTra = :type')
                ->setParameter('type', $type);
        }

        if ($startDate) {
            $queryBuilder->andWhere('t.dateTra >= :startDate')
                ->setParameter('startDate', $startDate);
        }

        if ($endDate) {
            $queryBuilder->andWhere('t.dateTra <= :endDate')
                ->setParameter('endDate', $endDate);
        }

        return $queryBuilder->getQuery()->getResult();
    }
    // Dans votre TransactionRepository

public function calculateSumByType($type)
{
    return $this->createQueryBuilder('t')
    ->select('SUM(t.montant)')
    ->where('t.typeTra = :type')
    ->setParameter('type', $type)
    ->getQuery()
    ->getSingleScalarResult();
}
}


