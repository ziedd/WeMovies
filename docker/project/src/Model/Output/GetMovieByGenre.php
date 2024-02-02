<?php

declare(strict_types=1);

namespace App\Model\Output;

use App\Model\Input\Genre;
use App\Model\Input\Movie;

final readonly class GetMovieByGenre
{
    public function __construct(
        public ?Genre $genre,
        public Movie $movie)
    {
    }
}
