<?php

declare(strict_types=1);

namespace App\Model\Output;

use App\Model\Input\Genre;
use App\Model\Input\Movie;

class ListOfGenre
{
    /**
     * @param Movie[] $movies
     */
    public function __construct(
        public Genre $genre,
        public array $movies)
    {
    }
}
