<?php

declare(strict_types=1);

namespace App\Adapter;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class HttpClientAdapter
{
    public function __construct(public HttpClientInterface $httpClient)
    {
    }

    public function request(string $method, string $url, array $options = []): array
    {
        $response = $this->httpClient->request($method, $url, $options);

        return $response->toArray();
    }
}
