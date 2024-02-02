<?php

declare(strict_types=1);

namespace App\Model\Input;

use App\Model\Output\MovieVideo;
use App\Model\Output\ProductionCompanyMovies;

final readonly class Movie
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ?string $imageUrl,
        public \DateTimeImmutable $releasedYear,
        public ?ProductionCompanyMovies $productionCompany,
        public array $genres,
        public int $voteCount,
        public float $rating,
        public ?MovieVideo $video)
    {
    }
}
