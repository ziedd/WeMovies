<?php

namespace App\Model\Output;

final readonly class MovieVideo
{
    public function __construct(
        public ?string $videoId,
        public ?string $videoName,
        public ?string $videoKey,
        public ?string $videoSite,
    ) {
    }
}
