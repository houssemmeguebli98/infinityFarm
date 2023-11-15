<?php
// src/Repository/UsersRepository.php
namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UsersRepository extends ServiceEntityRepository
{
public function __construct(ManagerRegistry $registry)
{
parent::__construct($registry, Users::class);
}

public function findBySearchTerm($searchTerm)
{
return $this->createQueryBuilder('u')
->where('u.nom LIKE :searchTerm')
->setParameter('searchTerm', '%' . $searchTerm . '%')
->getQuery()
->getResult();
}
}
