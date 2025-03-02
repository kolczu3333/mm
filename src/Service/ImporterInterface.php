<?php

namespace App\Service;

interface ImporterInterface
{
    public function fetchProducts(): array;
}