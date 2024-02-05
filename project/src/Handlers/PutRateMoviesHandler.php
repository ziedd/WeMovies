<?php

declare(strict_types=1);

namespace App\Handler;

use App\Adapter\HttpClientAdapterInterface;
use App\Model\Input\Movie;
use App\Model\Output\GetMovieByGenre;
use App\Model\Output\MovieVideo;
use App\Services\ApiConfigInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PutRateMoviesHandler
{
    public function __construct(private HttpClientAdapterInterface $httpClientAdapter, private ApiConfigInterface $apiConfig, public ParameterBagInterface $parameterBag)
    {
    }

    public function handle($movieId): GetMovieByGenre
    {
        $movie = $this->httpClientAdapter->request(
            'PUT',
            $this->apiConfig->putMovieRatingUri($movieId),
            $this->apiConfig->getApiRequestHeaders()
        );

        return new GetMovieByGenre($movie['genre'], new Movie(
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
