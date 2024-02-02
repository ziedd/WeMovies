<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetMovieHandler;
use App\Services\ApiConfigInterface;
use Negotiation\Tests\TestCase;

class GetMovieHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapterInterface::class);
        $apiConfigMock = $this->createMock(ApiConfigInterface::class);

        $this->getMovieHandler = new GetMovieHandler($httpClientAdapterMock, $apiConfigMock);
    }

    public function testHandle()
    {
        $movieId = 1;
        $genre = null;

        $mockMovie = [
            'id' => $movieId,
            'title' => 'Test Movie',
            'overview' => 'This is a test movie.',
            'poster_path' => '/path/to/poster',
            'release_date' => '2022-01-01',
            'vote_count' => 100,
            'vote_average' => 7.5,
            'video' => [
                'key' => 'test_key',
                'name' => 'test_name',
                'type' => 'test_type',
                'site' => 'test_site',
            ],
        ];

        $this->getMovieHandler->method('handle')->willReturn($mockMovie);

        $result = $this->getMovieHandler->handle($movieId, $genre);

        $this->assertInstanceOf(GetMovieByGenre::class, $result);
        $this->assertEquals($mockMovie['id'], $result->getMovie()->getId());
        $this->assertEquals($mockMovie['title'], $result->getMovie()->getTitle());
    }
}
