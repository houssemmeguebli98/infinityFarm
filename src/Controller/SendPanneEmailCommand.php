<?php
// src/Command/SendPanneEmailCommand.php

namespace App\Command;

use App\Repository\MaterielRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Console\Style\SymfonyStyle;

class SendPanneEmailCommand extends Command
{
    private MaterielRepository $materielRepository;
    private MailerInterface $mailer;

    public function __construct(MaterielRepository $materielRepository, MailerInterface $mailer)
    {
        parent::__construct();

        $this->materielRepository = $materielRepository;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this
            ->setName('send:panne-email')
            ->setDescription('Send an email with the list of materials in panne.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // Récupérer les matériels en panne depuis la base de données
        $materielsEnPanne = $this->materielRepository->findMaterielsEnPanne();

        // Vérifier s'il y a des matériels en panne
        if (empty($materielsEnPanne)) {
            $io->success('Aucun matériel en panne trouvé.');
            return Command::SUCCESS;
        }

        // Construire le contenu de l'e-mail au format HTML
        $htmlContent = '<ul>';
        foreach ($materielsEnPanne as $materiel) {
            $htmlContent .= '<li>' . $materiel->getNommat() . '</li>';
        }
        $htmlContent .= '</ul>';

        // Envoyer l'e-mail
        $email = (new Email())
            ->from('houssemmeguebli@outlook.com') // Remplacez par votre adresse e-mail
            ->to('megbli.houssam@gmail.com') // Remplacez par l'adresse e-mail du destinataire
            ->subject('Liste des matériels en panne')
            ->html($htmlContent);

        try {
            $this->mailer->send($email);
            $io->success('E-mail envoyé avec succès!');
        } catch (TransportExceptionInterface $e) {
            $io->error('Erreur lors de l\'envoi de l\'e-mail : ' . $e->getMessage());
        }

        return Command::SUCCESS;
    }
    #[Route('/send-panne-email', name: 'send_panne_email')]
    public function sendPanneEmail(MailerInterface $mailer, MaterielRepository $materielRepository): Response
    {
        // Récupérer les matériels en panne
        $materielsEnPanne = $materielRepository->findMaterielsEnPanne();

        // Vérifier s'il y a des matériels en panne
        if (count($materielsEnPanne) > 0) {
            $email = (new Email())
                ->from('houssemmeguebli@outlook.com')
                ->to('megbli.houssam@gmail.com')
                ->subject('Liste des matériels en panne')
                ->html($this->renderView('mail/liste_panne_email.html.twig', ['materiels' => $materielsEnPanne]));

            try {
                $mailer->send($email);
                $this->addFlash('success', 'Email envoyé avec succès !');
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('error', 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage());
            }
        } else {
            $this->addFlash('info', 'Aucun matériel en panne à signaler.');
        }

        return $this->redirectToRoute('app_mail'); // Remplacez 'app_mail' par le nom de la route que vous souhaitez afficher après l'envoi.
    }
}
