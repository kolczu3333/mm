<?php

namespace App\Service\Normalizer;

use App\Dto\ProductDto;

class ProductNormalizer
{
    public function normalize(array $product): ProductDto
    {
        return new ProductDto(
            externalId: trim($product['externalId'] ?? ''),
            name: trim(strip_tags($product['name'] ?? '')),
            price: max(0, (float) str_replace(',', '.', $product['price'] ?? 0)),
            stock: max(0, (int) $product['stock'])
        );
    }
}
