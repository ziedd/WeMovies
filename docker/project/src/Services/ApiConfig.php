<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class ApiConfig implements ApiConfigInterface
{
    public function __construct(public ParameterBagInterface $parameterBag, public string $apiToken, public string $apiBaseUri, public string $defaultLanguage, public int $defaultPage)
    {
        $this->apiToken = $parameterBag->get('api_token');
        $this->apiBaseUri = $parameterBag->get('api_base_uri');
        $this->defaultLanguage = $parameterBag->get('api_default_language');
        $this->defaultPage = $parameterBag->get('api_default_page');
    }

    public function getApiRequestHeaders(): array
    {
        return [
            'headers' => [
                'Authorization' => 'Bearer '.$this->apiToken,
                'Accept' => 'application/json',
            ],
        ];
    }

    public function getListOfGenreUri(string $language = null, int $page = null): string
    {
        $language = $language ?? $this->defaultLanguage;
        $page = $page ?? $this->defaultPage;

        return sprintf(
            '%s/genre/movie/list?language=%s&page=%d',
            $this->apiBaseUri,
            $language,
            $page
        );
    }

    public function getMovieDetailsUri(int $movieId): string
    {
        return sprintf(
            '%s/movie/%d?append_to_response=videos&language=%s',
            $this->apiBaseUri,
            $movieId,
            $this->defaultLanguage
        );
    }

    public function getSearchMovie(string $query, int $page = 1): string
    {
        return sprintf(
            '%s/search/movie?query=%s&page=%d',
            $this->apiBaseUri,
            $query,
            $page
        );
    }

    public function putMovieRatingUri(int $movieId): string
    {
        return sprintf(
            '%s/api/movies/%d/rating',
            $this->apiBaseUri,
            $movieId
        );
    }
}
