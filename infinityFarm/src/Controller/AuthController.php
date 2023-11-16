<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class AuthController extends AbstractController
{
    #[Route('/signin', name: 'app_signin')]
    public function signin(AuthenticationUtils $authenticationUtils): Response
    {
        // Récupérer les erreurs de connexion (le cas échéant)
        $error = $authenticationUtils->getLastAuthenticationError();

        // Récupérer le dernier email saisi par l'utilisateur
        $lastEmail = $authenticationUtils->getLastUsername();

        // Le rendu du formulaire de connexion (login)
        return $this->render('auth/signin.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error,
        ]);
    }







    #[Route('/signin_check', name: 'app_signin_check')]
    public function signinCheck(Request $request, EntityManagerInterface $entityManager): Response
    {
        $email = $request->request->get('_email');
        $password = $request->request->get('_password');

        // Recherche de l'utilisateur avec l'email fourni
        $user = $entityManager->getRepository(Users::class)->findOneBy(['mail' => $email]);

        if ($user) {
            // Vérification du mot de passe
            if ($user->getMotdepasse() === $password) {
                // Redirection en fonction du rôle
                switch ($user->getRole()) {
                    case 'ADMIN':
                        return $this->redirectToRoute('app_admin_index');
                        break;
                    case 'AGRICULTEUR':
                        return $this->redirectToRoute('agri_dashboard');
                        break;
                    case 'OUVRIER':
                        return $this->redirectToRoute('ouvrier_dashboard');
                        break;
                    default:
                        // Redirection par défaut si le rôle n'est pas reconnu
                        return $this->redirectToRoute('app_signup');
                }
            } else {
                $this->addFlash('error', 'Mot de passe incorrect');
                return $this->redirectToRoute('app_signin');
            }
        } else {
            $this->addFlash('error', 'Email incorrect');
            return $this->redirectToRoute('app_signin');
        }
    }


}
