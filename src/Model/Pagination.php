<?php

namespace App\Model;

final readonly class Pagination
{
    public function __construct(
        public int $page,
        public int $perPage,
    ) {}
}
