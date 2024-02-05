<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginPageController extends AbstractController
{
    #[Route('/login', name: 'app_login_page', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('authentification/login.html.twig');
    }
}
