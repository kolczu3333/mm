<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Normalizer\ProductNormalizer;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

readonly class ProductService
{
    public function __construct(private ProductRepository $productRepository, private ProductNormalizer $normalizer)
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function import(ImporterInterface $importer): void
    {
        $products = $importer->fetchProducts();

        foreach ($products as $data) {
            $normalizedData = $this->normalizer->normalize($data);
            $product = $this->productRepository->findByExternalId($normalizedData['externalId']);

            if (!$product) {
                $product = new Product();
                $product->setExternalId($normalizedData['externalId']);
                $product->setName($normalizedData['name']);
                $product->setPrice($normalizedData['price']);
                $product->setStock($normalizedData['stock']);

                $this->productRepository->save($product);
            } else {

                $this->productRepository->update($product);
            }

        }
    }

}