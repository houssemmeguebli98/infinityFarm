<?php

namespace App\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
    #[Route('/signup', name: 'app_signup')]
    public function signup(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            // Récupération des données
            $nom = $request->request->get('nom');
            $prenom = $request->request->get('prenom');
            $email = $request->request->get('email');
            $password = $request->request->get('password');

            // Validation des données (à compléter selon vos besoins)
            if (!$nom || !$prenom || !$email || !$password) {
                $this->addFlash('error', 'Veuillez remplir tous les champs.');
                return $this->redirectToRoute('app_signup');
            }

            // Vérification de l'unicité de l'email
            $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['mail' => $email]);
            if ($existingUser) {
                $this->addFlash('error', 'Cet email est déjà enregistré.');
                return $this->redirectToRoute('app_signup');
            }

            // Création d'un nouvel utilisateur
            $user = new Users();
            $user->setNom($nom);
            $user->setPrenom($prenom);
            $user->setMail($email);
            $user->setMotdepasse(password_hash($password, PASSWORD_BCRYPT));

            // Enregistrement dans la base de données
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_signin');
        }

        return $this->render('auth/signup.html.twig');
    }


}
