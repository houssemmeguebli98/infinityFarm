<?php

// src/Service/MailService.php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Psr\Log\LoggerInterface;

class MailService
{
    private MailerInterface $mailer;
    private LoggerInterface $logger;

    public function __construct(MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->mailer = $mailer;
        $this->logger = $logger;
    }

    public function sendActivationEmail(string $recipient, string $subject, string $content): void
    {
        $email = (new Email())
            ->from('houssemmeguebli@outlook.com') // Adresse expéditeur
            ->to($recipient) // Adresse destinataire
            ->subject($subject)
            ->html($content);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            // Log the exception
            $this->logger->error('Error sending email: ' . $exception->getMessage());

            // Optionally, you can rethrow the exception to let it propagate
            // throw $exception;
        }
    }
}
