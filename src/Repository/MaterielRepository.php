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
}

