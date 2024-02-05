<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetListOfGenreByMoviesHandler;
use App\Model\Output\ListOfGenre;
use App\Services\ApiConfigInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

it('returns list of genres with valid data', function () {
    $httpClientAdapter = $this->createMock(HttpClientAdapterInterface::class);
    $apiConfig = $this->createMock(ApiConfigInterface::class);
    $parameterBag = $this->createMock(ParameterBagInterface::class);
    $handler = new GetListOfGenreByMoviesHandler($httpClientAdapter, $apiConfig, $parameterBag);

    $apiConfig->method('getListOfGenreUri')->willReturn('some_uri');
    $apiConfig->method('getApiRequestHeaders')->willReturn([]);
    $httpClientAdapter->method('request')->willReturn([
        'genres' => [
            [
                'id' => 1,
                'title' => 'Movie 1',
                'overview' => 'Overview 1',
                'poster_path' => '/path/to/poster',
                'release_date' => '2022-01-01',
                'vote_count' => 100,
                'vote_average' => 7.5,
                'video' => [
                    'key' => 'video_key',
                    'name' => 'video_name',
                    'type' => 'video_type',
                    'site' => 'video_site',
                ],
            ],
            // Add more genres as needed
        ],
    ]);
    $parameterBag->method('get')->willReturn('http://image.url');

    $result = $handler->handle();

    $this->assertInstanceOf(ListOfGenre::class, $result);
});

it('returns list of genres without poster path', function () {
    $httpClientAdapter = $this->createMock(HttpClientAdapterInterface::class);
    $apiConfig = $this->createMock(ApiConfigInterface::class);
    $parameterBag = $this->createMock(ParameterBagInterface::class);
    $handler = new GetListOfGenreByMoviesHandler($httpClientAdapter, $apiConfig, $parameterBag);

    $apiConfig->method('getListOfGenreUri')->willReturn('some_uri');
    $apiConfig->method('getApiRequestHeaders')->willReturn([]);
    $httpClientAdapter->method('request')->willReturn([
        'genres' => [
            [
                'id' => 1,
                'title' => 'Movie 1',
                'overview' => 'Overview 1',
                'poster_path' => null,
                'release_date' => '2022-01-01',
                'vote_count' => 100,
                'vote_average' => 7.5,
                'video' => [
                    'key' => 'video_key',
                    'name' => 'video_name',
                    'type' => 'video_type',
                    'site' => 'video_site',
                ],
            ],
        ],
    ]);

    $result = $handler->handle();

    $this->assertInstanceOf(ListOfGenre::class, $result);
});
