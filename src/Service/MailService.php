<?php

// src/Service/MailService.php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailService
{
private MailerInterface $mailer;

public function __construct(MailerInterface $mailer)
{
$this->mailer = $mailer;
}

public function sendActivationEmail(string $recipient, string $subject, string $content): void
{
$email = (new Email())
->from('hassan.jlassi@esprit-tn.com') // Adresse expéditeur
->to($recipient) // Adresse destinataire
->subject($subject)
->html($content);

    try {
        $this->mailer->send($email);
    } catch (TransportExceptionInterface) {
    }
}
}
