<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\SmsService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class ResetSmsController extends AbstractController
{
    private $entityManager;
    private $smsService;

    public function __construct(EntityManagerInterface $entityManager, SmsService $smsService)
    {
        $this->entityManager = $entityManager;
        $this->smsService = $smsService;
    }

    #[Route('/reset-sms', name: 'reset_sms')]
    public function resetSms(Request $request): Response
    {
        return $this->render('send_sms/index.html.twig');
    }

    #[Route('/send-sms', name: 'send_sms', methods: ['POST'])]
    public function sendSms(Request $request): Response
    {
        $phoneNumber = $request->request->get('phoneNumber');
        $userRepository = $this->getDoctrine()->getRepository(User::class);
        $user = $userRepository->findOneBy(['numerotelephone' => $phoneNumber]);

        if (!$user) {
            $this->addFlash('error', 'Numéro de téléphone non enregistré.');
            return $this->redirectToRoute('reset_sms');
        }

        $verificationCode = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

        $sql = "INSERT INTO reset_password2 (phone, reset_code2, created_at) VALUES (?, ?, NOW())";
        $this->entityManager->getConnection()->executeStatement($sql, [$phoneNumber, $verificationCode]);

        $phoneNumberWithCountryCode = '+216' . $phoneNumber;
        $this->smsService->sendSms($phoneNumberWithCountryCode, 'Votre code de réinitialisation est : ' . $verificationCode);

        $this->addFlash('success', 'Code de vérification envoyé avec succès par SMS!');

        return $this->redirectToRoute('verify_sms', ['phone_number' => $phoneNumber]);
    }

    #[Route('/verify-sms/{phone_number}', name: 'verify_sms')]
    public function verifySms(Request $request, string $phone_number): Response
    {
        return $this->render('send_sms/verify_sms.html.twig', [
            'phone_number' => $phone_number,
        ]);
    }

    #[Route('/verification-sms', name: 'verification_sms', methods: ['POST'])]
    public function processVerification(Request $request): Response
    {
        $phone = $request->request->get('phone_number');
        $codeFromUser = $request->request->get('verification_code');

        $codeFromDatabase = $this->entityManager->getConnection()->fetchOne(
            "SELECT reset_code2 FROM reset_password2 WHERE phone = ? ORDER BY id DESC LIMIT 1",
            [$phone]
        );

        if (strcasecmp($codeFromUser, $codeFromDatabase) === 0) {
            return $this->redirectToRoute('reset_password_phone', ['phone' => $phone]);
        } else {
            return $this->render('send_sms/failure.html.twig');
        }
    }

    #[Route('/reset-password/{phone}', name: 'reset_password_phone')]
    public function resetPasswordPhone(Request $request, string $phone): Response
    {
        if (empty($phone)) {
            // Gérer le cas où le numéro de téléphone est manquant
            // Vous pouvez rediriger l'utilisateur vers une autre page ou afficher un message d'erreur
            // par exemple : return $this->redirectToRoute('some_other_route');
        }

        return $this->render('send_sms/reset_password_phone.html.twig', [
            'phone' => $phone,
        ]);
    }

    #[Route('/process-reset-password-phone', name: 'process_reset_password_phone', methods: ['POST'])]
    public function processResetPasswordPhone(
        Request $request,
        ValidatorInterface $validator,
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager // Ajoutez cette ligne
    ): Response {
        $phone = $request->request->get('phone');
        $newPassword = $request->request->get('new_password');

        $errors = [];

        // Valider le mot de passe
        $constraints = new Assert\Collection([
            'new_password' => [
                new Assert\NotBlank(['message' => 'Le mot de passe ne peut pas être vide.']),
                new Assert\Length(['min' => 8, 'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères.']),
                new Assert\Regex([
                    'pattern' => '/^(?=.*[A-Z])(?=.*\d).+$/',
                    'message' => 'Le mot de passe doit contenir au moins une lettre majuscule et un chiffre.',
                ]),
            ],
        ]);

        $data = ['new_password' => $newPassword];
        $violations = $validator->validate($data, $constraints);

        foreach ($violations as $violation) {
            $propertyPath = $violation->getPropertyPath();
            $message = $violation->getMessage();

            // Utiliser le nom du champ comme clé dans le tableau d'erreurs
            $errors[$propertyPath] = $message;
        }

        // Si des erreurs sont présentes, afficher les messages d'erreur sur la même page
        if (!empty($errors)) {
            return $this->render('send_sms/reset_password_phone.html.twig', [
                'errors' => $errors,
                'phone' => $phone,
            ]);
        }

        // Construire la requête SQL pour mettre à jour le mot de passe
        $sql = "UPDATE user SET password = :encodedPassword WHERE numeroTelephone = :phone";
        $params = [
            'encodedPassword' => $passwordEncoder->encodePassword(new User(), $newPassword),
            'phone' => $phone,
        ];

        // Exécuter la requête SQL
        $statement = $entityManager->getConnection()->prepare($sql);
        $statement->execute($params);

        // Rediriger l'utilisateur vers une page de confirmation ou de connexion
        return $this->redirectToRoute('app_login');
    }

}
