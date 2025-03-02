<?php

namespace App\Service\Normalizer;

class ProductNormalizer
{
    public function normalize(array $product): array
    {
        return [
            'externalId' => $this->sanitizeExternalId($data['externalId'] ?? ''),
            'name' => $this->sanitizeName($data['name']?? ''),
            'price' => $this->sanitizePrice($data['price']?? 0),
            'stock' => $this->sanitizeStock($data['stock']?? 0)
        ];
    }

    private function sanitizeExternalId(string $externalId): string
    {
        return trim($externalId);
    }

    private function sanitizeName(mixed $name): string
    {
        return trim(strip_tags($name));
    }

    private function sanitizePrice(mixed $price)
    {
        return max(0, (float) str_replace(',', '.', $price));
    }

    private function sanitizeStock(mixed $stock): int
    {
        return max(0, (int) $stock);
    }
}
