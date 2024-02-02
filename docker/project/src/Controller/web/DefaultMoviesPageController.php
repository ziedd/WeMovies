<?php

namespace App\Controller\web;

use App\Handler\GetListOfGenreByMoviesHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultMoviesPageController extends AbstractController
{
    public function __construct(public GetListOfGenreByMoviesHandler $getListOfGenreByMoviesHandler)
    {
    }

    #[Route('/', name: 'app_movies_default_page', methods: ['GET'])]
    public function index(): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('app_login_page');
        }

        $genres = $this->getListOfGenreByMoviesHandler->handle();

        return $this->render('defaultMoviesPage/default_page.html.twig', [
            'genres' => $genres,
        ]);
    }
}
