<?php

namespace App\Model\Output;

final readonly class ProductionCompanyMovies
{
    public function __construct(
        public int $companyId,
        public string $companyName,
        public ?string $companyLogoPath,
    ) {
    }
}
