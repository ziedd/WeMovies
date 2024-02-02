<?php

declare(strict_types=1);

namespace App\Handler;

use App\Adapter\HttpClientAdapterInterface;
use App\Model\Output\SearchMovie;
use App\Services\ApiConfigInterface;
use App\Services\SearchedMovieCollection;

class GetSearchMovieHandler implements HandlerInterface
{
    public function __construct(private HttpClientAdapterInterface $httpClientAdapter, private ApiConfigInterface $apiConfig, public SearchedMovieCollection $searchedMovieCollection)
    {
    }

    public function handle($query, $page): array
    {
        $searchmovies = $this->httpClientAdapter->request(
            'GET',
            $this->apiConfig->getSearchMovie($query, $page),
            $this->apiConfig->getApiRequestHeaders()
        );

        $resources = [];
        foreach ($searchmovies['results'] as $movie) {
            $companyName = $videoUrl = null;
            if (isset($gotMovieOutputs[$movie->id])) {
                $companyName = $gotMovieOutputs[$movie->id]->movie->getCompanyName();
            }

            if (isset($gotMovieOutputs[$movie->id])) {
                $videoUrl = $gotMovieOutputs[$movie->id]->movie->getVideoUrl();
            }

            $resources[] = new SearchMovie(
                $movie->title,
                $movie->description,
                $movie->imageUrl ? self::IMAGE_BASE_URL.'/'.$movie->imageUrl : null,
                $movie->releasedYear->format('Y'),
                $movie->id,
                $movie->genres,
                $movie->voteCount,
                (int) round($movie->rating / 2),
                $companyName,
                $videoUrl,
            );
        }

        return ['items' => $resources];
    }
}
