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
            $normalizedProductDto = $this->normalizer->normalize($data);
            $product = $this->productRepository->findByExternalId($normalizedProductDto->externalId);

            if (!$product) {
                $product = new Product();
                $product->setExternalId($normalizedProductDto->externalId);
                $product->setName($normalizedProductDto->name);
                $product->setPrice($normalizedProductDto->price);
                $product->setStock($normalizedProductDto->stock);

                $this->productRepository->save($product);
            } else {

                $this->productRepository->update($product);
            }

        }
    }

}