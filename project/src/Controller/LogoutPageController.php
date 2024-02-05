<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LogoutPageController extends AbstractController
{
    #[Route('/logout', name: 'app_logout_page', methods: ['GET'])]
    public function index(): Response
    {
        return $this->redirectToRoute('app_login_page');
    }
}
