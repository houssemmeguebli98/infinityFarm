<?php

namespace App\Controller;

use App\Entity\Ressource;
use App\Entity\Terrain;
use App\Form\RessourceType;
use App\Form\TerrainType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/terrain')]
class TerrainController extends AbstractController
{
    #[Route('/', name: 'app_terrain_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $terrains = $entityManager
            ->getRepository(Terrain::class)
            ->findAll();

        return $this->render('terrain/index.html.twig', [
            'terrains' => $terrains,
        ]);
    }

    #[Route('/new', name: 'app_terrain_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($terrain);
            $entityManager->flush();

            return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terrain/new.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/{idterrain}', name: 'app_terrain_show', methods: ['GET'])]
    public function show(Terrain $terrain): Response
    {
        $ressources = $terrain->getRessources();

        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
            'ressources' => $ressources,
        ]);
    }

    #[Route('/{idterrain}/edit', name: 'app_terrain_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('terrain/edit.html.twig', [
            'terrain' => $terrain,
            'form' => $form,
        ]);
    }

    #[Route('/{idterrain}', name: 'app_terrain_delete', methods: ['POST'])]
    public function delete(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $terrain->getIdterrain(), $request->request->get('_token'))) {
            $entityManager->remove($terrain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_terrain_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/terrain/{idterrain}/edit-ressource/{idres}', name: 'app_terrain_edit_ressource', methods: ['GET', 'POST'])]
    public function editRessource(Request $request, Terrain $terrain, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Redirect back to the terrain show page after editing the resource
            return $this->redirectToRoute('app_terrain_show', ['idterrain' => $terrain->getIdterrain()]);
        }

        return $this->renderForm('ressource/edit.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }

    #[Route('/terrain/{idterrain}/delete-ressource/{idres}', name: 'app_terrain_delete_ressource', methods: ['GET'])]
    public function deleteRessource(Terrain $terrain, Ressource $ressource, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($ressource);
        $entityManager->flush();

        // Redirect back to the terrain show page after deleting the resource
        return $this->redirectToRoute('app_terrain_show', ['idterrain' => $terrain->getIdterrain()]);
    }

    #[Route('/terrain/{idterrain}/new-ressource', name: 'app_terrain_new_ressource', methods: ['GET', 'POST'])]
    public function newRessource(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        $ressource = new Ressource();
        $ressource->setIdterrain($terrain); // Set the associated terrain

        $form = $this->createForm(RessourceType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ressource);
            $entityManager->flush();

            // Redirect back to the terrain show page after adding a new resource
            return $this->redirectToRoute('app_terrain_show', ['idterrain' => $terrain->getIdterrain()]);
        }

        return $this->renderForm('ressource/new.html.twig', [
            'ressource' => $ressource,
            'form' => $form,
        ]);
    }
}
