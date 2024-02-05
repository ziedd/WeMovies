<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetSearchMovieHandler;
use App\Services\ApiConfigInterface;
use App\Services\SearchedMovieCollection;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

it('returns search results with valid data', function () {
    $httpClientAdapter = $this->createMock(HttpClientAdapterInterface::class);
    $apiConfig = $this->createMock(ApiConfigInterface::class);
    $searchedMovieCollection = $this->createMock(SearchedMovieCollection::class);
    $parameterBag = $this->createMock(ParameterBagInterface::class);
    $handler = new GetSearchMovieHandler($httpClientAdapter, $apiConfig, $searchedMovieCollection, $parameterBag);

    $apiConfig->method('getSearchMovie')->willReturn('some_uri');
    $apiConfig->method('getApiRequestHeaders')->willReturn([]);
    $httpClientAdapter->method('request')->willReturn([
        'results' => [
            [
                'title' => 'Movie 1',
                'description' => 'Overview 1',
                'imageUrl' => '/path/to/poster',
                'releasedYear' => new DateTime('2022-01-01'),
                'id' => 1,
                'genres' => ['Genre 1'],
                'voteCount' => 100,
                'rating' => 7.5,
            ],
        ],
    ]);
    $parameterBag->method('get')->willReturn('http://image.url');

    $result = $handler->handle('query', 1);

    $this->assertIsArray($result);
    $this->assertArrayHasKey('items', $result);
});

it('returns search results without image url', function () {
    $httpClientAdapter = $this->createMock(HttpClientAdapterInterface::class);
    $apiConfig = $this->createMock(ApiConfigInterface::class);
    $searchedMovieCollection = $this->createMock(SearchedMovieCollection::class);
    $parameterBag = $this->createMock(ParameterBagInterface::class);
    $handler = new GetSearchMovieHandler($httpClientAdapter, $apiConfig, $searchedMovieCollection, $parameterBag);

    $apiConfig->method('getSearchMovie')->willReturn('some_uri');
    $apiConfig->method('getApiRequestHeaders')->willReturn([]);
    $httpClientAdapter->method('request')->willReturn([
        'results' => [
            [
                'title' => 'Movie 1',
                'description' => 'Overview 1',
                'imageUrl' => null,
                'releasedYear' => new DateTime('2022-01-01'),
                'id' => 1,
                'genres' => ['Genre 1'],
                'voteCount' => 100,
                'rating' => 7.5,
            ],
        ],
    ]);

    $result = $handler->handle('query', 1);

    $this->assertIsArray($result);
    $this->assertArrayHasKey('items', $result);
});
