<?php

namespace App\Controller;

use App\Entity\Parc;
use App\Form\ParcType;
use App\Form\SearchParcType;
use App\Repository\MaterielRepository;
use App\Repository\ParcRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parc')]
class ParcController extends AbstractController
{
    #[Route('/', name: 'app_parc_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $parcs = $entityManager
            ->getRepository(Parc::class)
            ->findAll();

        return $this->render('parc/index.html.twig', [
            'parcs' => $parcs,
        ]);
    }

    #[Route('/new', name: 'app_parc_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parc = new Parc();
        $form = $this->createForm(ParcType::class, $parc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Le nom du parc est unique, persistez et flush
            $entityManager->persist($parc);
            $entityManager->flush();

            return $this->redirectToRoute('app_parc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parc/new.html.twig', [
            'parc' => $parc,
            'form' => $form,
        ]);
    }
    #[Route('/{idparc}', name: 'app_parc_show', methods: ['GET'])]
    public function show(Parc $parc): Response
    {
        return $this->render('parc/show.html.twig', [
            'parc' => $parc,
        ]);
    }

    #[Route('/{idparc}/edit', name: 'app_parc_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parc $parc, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParcType::class, $parc);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parc_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parc/edit.html.twig', [
            'parc' => $parc,
            'form' => $form,
        ]);
    }

    #[Route('/{idparc}', name: 'app_parc_delete', methods: ['POST'])]
    public function delete(Request $request, Parc $parc, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parc->getIdparc(), $request->request->get('_token'))) {
            $entityManager->remove($parc);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parc_index', [], Response::HTTP_SEE_OTHER);
    }
    private function getParcNames(EntityManagerInterface $entityManager): array
    {
        $parcs = $entityManager
            ->getRepository(Parc::class)
            ->findAll();

        $parcNames = [];

        foreach ($parcs as $parc) {
            $parcNames[] = $parc->getNomParc();
        }

        return $parcNames;
    }

    #[Route('/statistiques', name: 'app_statistiques')]
    public function statistiques(EntityManagerInterface $entityManager): Response
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
        return $this->render('parc/statistiques.html.twig', [
            'parcData' => json_encode($parcData),
        ]);
    }
    #[Route('/findbyname', name: 'find_name_parc', methods: ['GET'])]
    public function findByName(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nom = $request->get('nom');

        $qb = $entityManager->createQueryBuilder();
        $qb->select('p')
            ->from('App\Entity\Parc', 'p')
            ->where('p.nomparc = :nom')
            ->setParameter('nom', $nom);

        $parc = $qb->getQuery()->getOneOrNullResult();

        if ($parc) {
            return $this->render('parc/index.html.twig', [
                'parc' => $parc,
            ]);
        } else {
            return $this->render('parc/index.html.twig', [
                'parcs' => [],
                'nom' => $nom,
                'error' => 'No park found with the name: ' . $nom,
            ]);
        }
    }
}
