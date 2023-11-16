<?php

namespace App\Repository;

use App\Entity\Terrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TerrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Terrain::class);
    }

    /**
     * Search for terrains based on criteria.
     *
     * @param array $criteria An associative array of search criteria
     *
     * @return Terrain[] The array of matching terrains
     */
    public function search(array $criteria = []): array
    {
        $queryBuilder = $this->createQueryBuilder('t');

        foreach ($criteria as $field => $value) {
            // Adjust the comparison based on your needs (e.g., use '=' for exact match)
            $queryBuilder->andWhere("t.$field LIKE :$field")->setParameter($field, "%$value%");
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
