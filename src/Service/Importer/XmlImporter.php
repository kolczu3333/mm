<?php

namespace App\Service\Importer;

use App\Service\ImporterInterface;
use Exception;
use Psr\Log\LoggerInterface;

readonly class XmlImporter implements ImporterInterface
{
    public function __construct(private string $xmlFilePath, private LoggerInterface $logger)
    {
    }

    public function fetchProducts(): array
    {
        try {
            $xml = simplexml_load_file($this->xmlFilePath);
            if (!$xml) {
                throw new Exception('Nie udało się wczytać pliku XML.');
            }

            $products = [];

            foreach ($xml->product as $product) {
                $products[] = [
                    'externalId' => (string)$product->id,
                    'name' => (string)$product->name,
                    'price' => (float)$product->price,
                    'stock' => (int) $product->stock,
                ];
            }

            return $products;
        } catch (Exception $e) {
            $this->logger->error('Błąd parsowania XML: ' . $e->getMessage());

            return [];
        }
    }
}