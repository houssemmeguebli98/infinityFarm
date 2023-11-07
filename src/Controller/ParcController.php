<?php

namespace App\Controller;

use App\Entity\Parc;
use App\Form\ParcType;
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
}
