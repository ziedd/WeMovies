<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetListOfGenreByMoviesHandler;
use App\Services\ApiConfigInterface;
use Negotiation\Tests\TestCase;

class GetListOfGenreByMoviesHandlerTest extends TestCase
{
    protected function setUp(): void
    {
        $httpClientAdapterMock = $this->createMock(HttpClientAdapterInterface::class);
        $apiConfigMock = $this->createMock(ApiConfigInterface::class);
        $this->getListOfGenreByMoviesHandler = new GetListOfGenreByMoviesHandler($httpClientAdapterMock, $apiConfigMock);
    }

    public function testHandle()
    {
        $mockGenres = ['Action', 'Comedy', 'Drama']; // Remplacez ceci par la structure de données de genre réelle que vous utilisez.
        $this->getListOfGenreByMoviesHandler->method('handle')->willReturn($mockGenres);
        $result = $this->getListOfGenreByMoviesHandler->handle();
        $this->assertIsArray($result);
        $this->assertEquals($mockGenres, $result);
    }
}
