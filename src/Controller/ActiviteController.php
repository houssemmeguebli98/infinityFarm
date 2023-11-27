<?php

namespace App\Controller;

use App\Entity\Activite;
use App\Form\ActiviteType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MailService;
use Knp\Snappy\Pdf;

#[Route('/activite')]
class ActiviteController extends AbstractController
{
    private MailService $mailService;

    // Injectez le service dans le constructeur
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    #[Route('/', name: 'app_activite_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $query = $entityManager->getRepository(Activite::class)->createQueryBuilder('a')->getQuery();

        $activites = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), // Numéro de la page. Par défaut, 1.
            10 // Nombre d'éléments par page
        );

        return $this->render('activite/index.html.twig', [
            'activites' => $activites,
        ]);
    }

    #[Route('/new', name: 'app_activite_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $activite = new Activite();
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrez l'activité
            $entityManager->persist($activite);
            $entityManager->flush();

            // Envoyez l'e-mail
            $subject = 'Nouvelle activité enregistrée';
            $content = 'Une nouvelle activité a été enregistrée.';
            $recipient = $activite->getEmaildist();

            $this->mailService->sendActivationEmail($recipient, $subject, $content);

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite/new.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{idact}', name: 'app_activite_show', methods: ['GET'])]
    public function show(Activite $activite = null): Response
    {
        if ($activite === null) {
            // Rediriger l'utilisateur vers la page d'index s'il n'y a pas d'activité
            return $this->redirectToRoute('app_activite_index');
        }

        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }


    #[Route('/{idact}/edit', name: 'app_activite_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActiviteType::class, $activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('activite/edit.html.twig', [
            'activite' => $activite,
            'form' => $form,
        ]);
    }

    #[Route('/{idact}', name: 'app_activite_delete', methods: ['POST'])]
    public function delete(Request $request, Activite $activite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$activite->getIdact(), $request->request->get('_token'))) {
            $entityManager->remove($activite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/export-pdf', name: 'app_activite_export_pdf', methods: ['GET'])]
    public function exportPdf(EntityManagerInterface $entityManager, Pdf $pdf): Response
    {
        try {
            $activites = $entityManager->getRepository(Activite::class)->findAll();

            if (empty($activites)) {
                throw $this->createNotFoundException('Aucune activité trouvée');
            }

            $html = $this->renderView('activite/pdf.html.twig', [
                'activites' => $activites,
            ]);

            $filename = 'activites.pdf';

            return new Response(
                $pdf->getOutputFromHtml($html),
                200,
                [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                ]
            );
        } catch (\Exception $e) {
            // Gérer les erreurs (afficher ou journaliser l'erreur, etc.)
            dump($e->getMessage());
            // Retourner une réponse d'erreur si nécessaire
            return new Response('Erreur lors de la génération du PDF', 500);
        }
    }


}
