<?php

namespace App\Model\Output;

final readonly class SearchMovie
{
    public function __construct(
        public string $title,
        public string $description,
        public ?string $imageUrl,
        public \DateTimeImmutable $releasedYear,
        public int $id,
        public array $genres,
        public int $voteCount,
        public float $rating)
    {
    }
}
