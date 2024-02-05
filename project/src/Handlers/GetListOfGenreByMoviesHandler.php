<?php

declare(strict_types=1);

namespace App\Handler;

use App\Adapter\HttpClientAdapterInterface;
use App\Model\Input\Movie;
use App\Model\Output\ListOfGenre;
use App\Model\Output\MovieVideo;
use App\Services\ApiConfigInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GetListOfGenreByMoviesHandler
{
    public function __construct(private HttpClientAdapterInterface $httpClientAdapter, private ApiConfigInterface $apiConfig, public ParameterBagInterface $parameterBag)
    {
    }

    public function handle(): ListOfGenre
    {
        $genres[] = $this->httpClientAdapter->request(
            'GET',
            $this->apiConfig->getListOfGenreUri($this->apiConfig->defaultLanguage, $this->apiConfig->defaultPage),
            $this->apiConfig->getApiRequestHeaders()
        );

        return new ListOfGenre(...array_map(fn ($item) => new Movie(
            $item['id'],
            $item['title'],
            $item['overview'],
            $item['poster_path'] ? $this->parameterBag->get('api_image_url').$item['poster_path'] : null,
            new \DateTimeImmutable($item['release_date']),
            null,
            [],
            $item['vote_count'],
            $item['vote_average'],
            new MovieVideo($item['video']['key'], $item['video']['name'], $item['video']['type'], $item['video']['site'])
        ),
            array_values($genres['genres'])
        ));
    }
}
