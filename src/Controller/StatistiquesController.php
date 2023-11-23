<?php

namespace App\Controller;

use App\Entity\Parc;
use App\Repository\MaterielRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stat')]
class StatistiquesController extends AbstractController
{

    #[Route('/index', name: 'app_statistiques')]
    public function statistiques(EntityManagerInterface $entityManager,MaterielRepository $repository): Response
    {
        $parcRepository = $entityManager->getRepository(Parc::class);
        $parcs = $parcRepository->findAll();

        // Formattez les données selon les besoins de votre graphique
        $parcData = [
            'labels' => [], // Les étiquettes pour l'axe des X
            'values' => [], // Les valeurs correspondantes
        ];
        foreach ($parcs as $parc) {
            $parcData['labels'][] = $parc->getNomParc();
            $parcData['values'][] = $parc->getSuperficieparc();
        }
        return $this->render('statistiques/index.html.twig', [
            'parcData' => json_encode($parcData),
        ]);
    }

}
