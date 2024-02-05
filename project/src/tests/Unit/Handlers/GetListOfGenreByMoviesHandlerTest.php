<?php

use App\Adapter\HttpClientAdapterInterface;
use App\Handler\GetListOfGenreByMoviesHandler;
use App\Model\Output\ListOfGenre;
use App\Services\ApiConfigInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GetListOfGenreByMoviesHandlerTest extends TestCase
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
        $this->handler = new GetListOfGenreByMoviesHandler($this->httpClientAdapter, $this->apiConfig, $this->parameterBag);
    }

    public function testHandleReturnsListOfGenreWithValidData()
    {
        $this->apiConfig
            ->method('getListOfGenreUri')
            ->willReturn('some_uri');
        $this->apiConfig
            ->method('getApiRequestHeaders')
            ->willReturn([]);
        $this->httpClientAdapter
            ->method('request')
            ->willReturn([
            'genres' => [
                [
                    'id' => 1,
                    'title' => 'Genre 1',
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
            ],
        ]);
        $this->parameterBag
            ->method('get')
            ->willReturn('http://image.url');

        $result = $this->handler->handle();

        $this->assertInstanceOf(ListOfGenre::class, $result);
    }

    public function testHandleReturnsEmptyListOfGenreWithNoData()
    {
        $this->apiConfig
            ->method('getListOfGenreUri')
            ->willReturn('some_uri');
        $this->apiConfig
            ->method('getApiRequestHeaders')
            ->willReturn([]);
        $this->httpClientAdapter
            ->method('request')
            ->willReturn(['genres' => []]);

        $result = $this->handler->handle();

        $this->assertInstanceOf(ListOfGenre::class, $result);
        $this->assertCount(0, $result->getItems());
    }
}
