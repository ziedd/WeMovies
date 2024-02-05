<?php

declare(strict_types=1);

namespace App\Handler;

use App\Adapter\HttpClientAdapterInterface;
use App\Model\Input\Genre;
use App\Model\Input\Movie;
use App\Model\Output\GetMovieByGenre;
use App\Model\Output\MovieVideo;
use App\Services\ApiConfigInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GetMovieHandler
{
    public function __construct(private HttpClientAdapterInterface $httpClientAdapter, private ApiConfigInterface $apiConfig, public ParameterBagInterface $parameterBag)
    {
    }

    public function handle(int $movieId, ?Genre $genre): GetMovieByGenre
    {
        $movie = $this->httpClientAdapter->request(
            'GET',
            $this->apiConfig->getMovieDetailsUri($movieId),
            $this->apiConfig->getApiRequestHeaders()
        );

        return new GetMovieByGenre($genre, new Movie(
            $movie['id'],
            $movie['title'],
            $movie['overview'],
            $movie['poster_path'] ? $this->parameterBag->get('api_image_url').$movie['poster_path'] : null,
            new \DateTimeImmutable($movie['release_date']),
            null,
            [],
            $movie['vote_count'],
            $movie['vote_average'],
            new MovieVideo($movie['video']['key'], $movie['video']['name'], $movie['video']['type'], $movie['video']['site'])));
    }
}
