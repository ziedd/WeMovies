<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetMovieHandler;
use App\Model\Input\Genre;
use App\Model\Output\GetMovieByGenre;
use App\Services\ApiConfigInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

it('returns movie with valid data', function () {
    $httpClientAdapter = $this->createMock(HttpClientAdapterInterface::class);
    $apiConfig = $this->createMock(ApiConfigInterface::class);
    $parameterBag = $this->createMock(ParameterBagInterface::class);
    $handler = new GetMovieHandler($httpClientAdapter, $apiConfig, $parameterBag);

    $apiConfig->method('getMovieDetailsUri')->willReturn('some_uri');
    $apiConfig->method('getApiRequestHeaders')->willReturn([]);
    $httpClientAdapter->method('request')->willReturn([
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
    ]);
    $parameterBag->method('get')->willReturn('http://image.url');

    $result = $handler->handle(1, new Genre(1, 'Genre 1'));

    $this->assertInstanceOf(GetMovieByGenre::class, $result);
});

it('returns movie without poster path', function () {
    $httpClientAdapter = $this->createMock(HttpClientAdapterInterface::class);
    $apiConfig = $this->createMock(ApiConfigInterface::class);
    $parameterBag = $this->createMock(ParameterBagInterface::class);
    $handler = new GetMovieHandler($httpClientAdapter, $apiConfig, $parameterBag);

    $apiConfig->method('getMovieDetailsUri')->willReturn('some_uri');
    $apiConfig->method('getApiRequestHeaders')->willReturn([]);
    $httpClientAdapter->method('request')->willReturn([
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
    ]);

    $result = $handler->handle(1, new Genre(1, 'Genre 1'));

    $this->assertInstanceOf(GetMovieByGenre::class, $result);
});
