<?php

namespace App\Services;

use App\Model\Output\SearchMovie;

class SearchedMovieCollection
{
    /**
     * @param SearchMovie[] $movies
     */
    public function __construct(public array $movies)
    {
    }

    public function orderByRating(): self
    {
        $sortedMovies = $this->movies;

        usort($sortedMovies, static function (SearchMovie $firstMovie, SearchMovie $secondMovie) {
            return $firstMovie->rating <=> $secondMovie->rating;
        });

        return new self($sortedMovies);
    }

    /**
     * @return SearchMovie[]
     */
    public function getThreeFirstResults($movies): array
    {
        return array_slice($movies, 0, 3);
    }
}
