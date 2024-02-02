<?php

declare(strict_types=1);

namespace App\Model\Input;

final readonly class Genre
{
    public function __construct(public int $id, public ?string $name)
    {
    }
}
