<?php
namespace App\Repository;

use App\Entity\Materiel;
use App\Form\SearchParcType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Parc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ParcRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parc::class);
    }

    public function getAllParcNames()
    {
        $parcs = $this->findAll();

        // Extrayez uniquement les noms de parc dans une liste
        $parcNames = array_map(function($parc) {
            return $parc->getNomParc();
        }, $parcs);

        return $parcNames;

    }
    public function getIdParcByName($nomParc): int
    {
        $parc = $this->findOneBy(['nomParc' => $nomParc]);
            return $parc->getIdParc();

    }


    /**
     * Récupère les matériels associés à un parc avec l'idParc donné.
     *
     * @param int $idParc
     * @return array
     */
    /*
    public function findMaterielsByParcId(int $idParc): array
    {
        return $this->createQueryBuilder('parc')
            ->select('materiel')
            ->join('parc.materiels', 'materiel')
            ->where('parc.idParc = :idParc')
            ->setParameter('idParc', $idParc)
            ->getQuery()
            ->getResult();
    }

*/





}
