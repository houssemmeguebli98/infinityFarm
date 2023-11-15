<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(Users::class)->findAll();
        return $this->render('admin/home.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $users, // Pass the users to the template
        ]);
    }
}
