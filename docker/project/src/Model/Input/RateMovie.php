<?php

namespace App\Model\Input;

final readonly class RateMovie
{
    public function __construct(public int $movieId, public int $rate)
    {
    }
}
