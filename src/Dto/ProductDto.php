<?php

namespace App\Dto;

readonly class ProductDto
{
    public function __construct(
        public  string $externalId,
        public string  $name,
        public float   $price,
        public int     $stock
    ) {}
}