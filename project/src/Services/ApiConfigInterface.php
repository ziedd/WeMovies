<?php

declare(strict_types=1);

namespace App\Services;

interface ApiConfigInterface
{
    public function getApiRequestHeaders(): array;

    public function getListOfGenreUri(string $language = null, int $page = null): string;

    public function getMovieDetailsUri(int $movieId): string;

    public function getSearchMovie(string $query, int $page = 1): string;

    public function putMovieRatingUri(int $movieId): string;
}
