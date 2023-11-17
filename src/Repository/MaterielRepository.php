<?php
// MaterielRepository.php
// MaterielRepository.php
namespace App\Repository;

use App\Entity\Materiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MaterielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Materiel::class);
    }

    public function findMaterielsByNomParc(string $nomparc): array
    {
        $query = $this->createQueryBuilder('m')
            ->where('m.nomparc = :nomparc')
            ->setParameter('nomparc', $nomparc)
            ->getQuery();

        return $query->getResult();
    }
    public function searchMatByCriteria(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('m');

        if (!empty($criteria['nommat'])) {
            $queryBuilder->andWhere('m.nommat LIKE :nommat')
                ->setParameter('nommat', '%' . $criteria['nommat'] . '%');
        }

        if (!empty($criteria['etatmat'])) {
            $queryBuilder->andWhere('m.etatmat LIKE :etatmat')
                ->setParameter('etatmat', '%' . $criteria['etatmat'] . '%');
        }

        if (!empty($criteria['quantitemat'])) {
            $queryBuilder->andWhere('m.quantitemat = :quantitemat')
                ->setParameter('quantitemat', $criteria['quantitemat']);
        }

        if (!empty($criteria['dateajout'])) {
            $queryBuilder->andWhere('m.dateajout = :dateajout')
                ->setParameter('dateajout', new \DateTime($criteria['dateajout']));
        }

        if (!empty($criteria['nomparc'])) {
            $queryBuilder->andWhere('m.nomparc LIKE :nomparc')
                ->setParameter('nomparc', '%' . $criteria['nomparc'] . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

}

