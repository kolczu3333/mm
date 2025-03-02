<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService
{
    public function __construct(private ProductRepository $productRepository)
    {
    }

    public function import(ImporterInterface $importer): void
    {
        $products = $importer->fetchProducts();

        foreach ($products as $data) {
            $product = $this->productRepository->findByExternalId($data['externalId']);

            if (!$product) {
                $product = new Product();
                $product->setExternalId($data['externalId']);
            }

            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setStock($data['stock']);

            $this->productRepository->save($product);
        }
    }

}