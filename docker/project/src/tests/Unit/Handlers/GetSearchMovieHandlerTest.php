<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetSearchMovieHandler;
use App\Model\Output\SearchMovie;
use App\Services\ApiConfigInterface;
use App\Services\SearchedMovieCollection;
use Negotiation\Tests\TestCase;

class GetSearchMovieHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapterInterface::class);
        $apiConfigMock = $this->createMock(ApiConfigInterface::class);
        $searchedMovieCollectionMock = $this->createMock(SearchedMovieCollection::class);
        $this->getSearchMovieHandler = new GetSearchMovieHandler($httpClientAdapterMock, $apiConfigMock, $searchedMovieCollectionMock);
    }

    public function testHandle()
    {
        $query = 'test';
        $page = 1;

        $mockSearchMovies = [
            'results' => [
                [
                    'id' => 1,
                    'title' => 'Test Movie',
                    'description' => 'This is a test movie.',
                    'imageUrl' => '/path/to/image',
                    'releasedYear' => new DateTimeImmutable('2022-01-01'),
                    'genres' => ['Action', 'Comedy'],
                    'voteCount' => 100,
                    'rating' => 7.5,
                ],
            ],
        ];

        $this->getSearchMovieHandler->method('handle')->willReturn($mockSearchMovies);
        $result = $this->getSearchMovieHandler->handle($query, $page);
        $this->assertIsArray($result);
        $this->assertCount(1, $result['items']);
        $this->assertInstanceOf(SearchMovie::class, $result['items'][0]);
        $this->assertEquals($mockSearchMovies['results'][0]['id'], $result['items'][0]->getId());
        $this->assertEquals($mockSearchMovies['results'][0]['title'], $result['items'][0]->getTitle());
    }
}
