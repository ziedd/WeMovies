<?php

declare(strict_types=1);

namespace App\Controller;

use App\Handler\GetListOfGenreByMoviesHandler;
use App\Handler\GetMovieHandler;
use App\Handler\GetSearchMovieHandler;
use App\Handler\PutRateMoviesHandler;
use App\Services\SearchedMovieCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MoviesController extends AbstractController
{
    public function __construct(public GetListOfGenreByMoviesHandler $getListOfGenreByMoviesHandler, public GetMovieHandler $getMovieHandler, public GetSearchMovieHandler $getSearchMovieHandler, public PutRateMoviesHandler $putRateMoviesHandler, public RequestStack $requestStack, public SearchedMovieCollection $searchedMovieCollection)
    {
    }

    #[Route('/api/genres/list', name: 'api_genres')]
    public function index(): Response
    {
        $genres = $this->getListOfGenreByMoviesHandler->handle();

        return $this->render('defaultMoviesPage/index.html.twig', [
            ['items' => $genres],
        ]);
    }

    #[Route('/api/movies/{movieId}', name: 'api_movies_get_item', methods: ['GET'], requirements: ['movieId' => '\d+'])]
    public function getMovie(int $movieId): Response
    {
        $genre = $this->requestStack->getCurrentRequest()->query->get('genre');

        $movies = $this->getMovieHandler->handle($movieId, $genre);

        return new JsonResponse($movies);
    }

    #[Route('/api/movies/search', name: 'api_movie_search')]
    public function searchMovie(): Response
    {
        $request = $this->requestStack->getCurrentRequest();
        $search = $request->query->get('search');
        $genreIds = $request->query->get('genreIds');
        $page = $request->query->get('page');

        if (null !== $genreIds) {
            $genreIds = \explode(',', $genreIds);
        }

        $query = [
            'search' => $search,
            'genreIds' => $genreIds,
        ];

        $moviesCollection = $this->getSearchMovieHandler->handle($query, $page);
        $gotMovies = [];
        foreach ($this->searchedMovieCollection->getThreeFirstResults($moviesCollection) as $movie) {
            $gotMovies[$movie->id] = $this->getMovieHandler->handle($movie->id, $movie->genres[]);
        }

        return new JsonResponse($gotMovies);
    }

    #[Route('/api/movies/{movieId}/rating', name: 'api_movies_rate_item', requirements: ['movieId' => '\d+'], methods: ['PUT']
    )]
    public function putRateMovies(int $movieId): Response
    {
        $rateMovie = $this->putRateMoviesHandler->handle($movieId);

        return new JsonResponse($rateMovie);
    }
}
