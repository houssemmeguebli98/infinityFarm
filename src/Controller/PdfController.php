<?php

namespace App\Controller;

use App\Repository\ParcRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use TCPDF;
use TCPDF as BaseTCPDF;

class PdfController extends AbstractController
{

    #[Route('/generate-pdf', name: 'generate_pdf')]
    public function generatePdf(EntityManagerInterface $entityManager, ParcRepository $parcRepository): Response
    {
        // Instancier TCPDF
        $pdf = new TCPDF();

        // Ajouter une police TrueType Unicode
        $fontPath = $this->getParameter('kernel.project_dir') . '/path-to-font/';
        $fontname = $fontPath . 'FreeSerifItalic.ttf';
        $pdf->AddFont('freeserif', '', $fontname, true);
        $pdf->SetFont('freeserif', '', 14);

        // Ajouter une page
        $pdf->AddPage();
        $pdf->Rect(5, 5, $pdf->GetPageWidth() - 10, $pdf->GetPageHeight() - 10);

        // Ajouter le titre dans la police personnalisée
        $pdf->SetFont('freeserif', '', 18); // Augmenter la taille de la police pour le titre
        $pdf->cell(0, 10, 'Liste des parcs', 0, 1, 'C'); // Utiliser la largeur de la page pour la cellule
        $pdf->SetFont('freeserif', '', 14); // Revenir à la taille de police précédente

        // Ajouter un saut de ligne
        $pdf->Ln(15); // Augmenter l'espace entre le titre et le tableau

        // Récupérer la liste des parcs directement via l'autowiring
        $parcs = $parcRepository->findAll();

        // Définir les en-têtes du tableau
        $headers = array('Nom du Parc', 'Adresse du Parc', 'Superficie du Parc');

        // Ajouter le tableau au PDF
        $pdf->SetFillColor(200, 220, 255);
        $pdf->SetFont('freeserif', 'B', 12); // Utiliser une police en gras pour les en-têtes

        // Ajouter les en-têtes du tableau
        foreach ($headers as $header) {
            $pdf->Cell(60, 10, $header, 1, 0, 'C', 1); // Augmenter la largeur de la cellule
        }
        $pdf->Ln();

        // Ajouter les données du tableau
        $pdf->SetFont('freeserif', '', 12); // Revenir à la taille de police précédente
        foreach ($parcs as $parc) {
            $pdf->Cell(60, 10, $parc->getNomparc(), 1);
            $pdf->Cell(60, 10, $parc->getAdresseparc(), 1);
            $pdf->Cell(60, 10, $parc->getSuperficieparc(), 1);
            $pdf->Ln();
        }

        // Ajouter un saut de ligne après le tableau
        $pdf->Ln(10);

        // Ajouter la date au pied de page avec "INFINITYFARM"
        $pdf->SetFont('freeserif', 'I', 10); // Utiliser une police italique pour la date
        $pdf->Cell(0, 10, ' ' . date('Y-m-d') . ' - INFINITYFARM', 0, 1, 'C');

        // Sortie du PDF
        $pdfContent = $pdf->Output('liste_parcs.pdf', 'S');

        // Réponse Symfony avec le contenu du PDF
        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
