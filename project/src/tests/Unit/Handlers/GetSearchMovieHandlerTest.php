<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetMovieHandler;
use App\Model\Input\Genre;
use App\Model\Output\GetMovieByGenre;
use App\Services\ApiConfigInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GetSearchMovieHandlerTest extends TestCase
{
    private $httpClientAdapter;
    private $apiConfig;
    private $parameterBag;
    private $handler;

    protected function setUp(): void
    {
        $this->httpClientAdapter = $this->createMock(HttpClientAdapterInterface::class);
        $this->apiConfig = $this->createMock(ApiConfigInterface::class);
        $this->parameterBag = $this->createMock(ParameterBagInterface::class);
        $this->handler = new GetMovieHandler($this->httpClientAdapter, $this->apiConfig, $this->parameterBag);
    }

    public function handleReturnsMovieWithValidData()
    {
        $this->apiConfig->method('getMovieDetailsUri')->willReturn('some_uri');
        $this->apiConfig->method('getApiRequestHeaders')->willReturn([]);
        $this->httpClientAdapter->method('request')->willReturn([
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
        $this->parameterBag->method('get')->willReturn('http://image.url');

        $result = $this->handler->handle(1, new Genre(1, 'Genre 1'));

        $this->assertInstanceOf(GetMovieByGenre::class, $result);
    }

    public function handleReturnsMovieWithoutPosterPath()
    {
        $this->apiConfig->method('getMovieDetailsUri')->willReturn('some_uri');
        $this->apiConfig->method('getApiRequestHeaders')->willReturn([]);
        $this->httpClientAdapter->method('request')->willReturn([
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

        $result = $this->handler->handle(1, new Genre(1, 'Genre 1'));

        $this->assertInstanceOf(GetMovieByGenre::class, $result);
    }
}
