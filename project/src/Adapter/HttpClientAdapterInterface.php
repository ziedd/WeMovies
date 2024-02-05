<?php

declare(strict_types=1);

namespace App\Adapter;

interface HttpClientAdapterInterface
{
    public function request(string $method, string $url, array $options = []): array;
}
