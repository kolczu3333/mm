<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;

readonly class ProductRepository
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function save(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws Exception
     */
    public function update(Product $product): void
    {
        $existingProduct = $this->em->find(Product::class, $product->getId());
        if ($existingProduct) {
            $existingProduct->setName($product->getName());
            $existingProduct->setPrice($product->getPrice());
            $existingProduct->setStock($product->getStock());

            $this->em->flush();
        } else {
            throw new Exception('Product not found');
        }
    }

    public function findByExternalId(string $externalId):?Product
    {
        $query = $this->em->createQuery(
            'SELECT p FROM App\Entity\Product p where p.externalId = :externalId'
        )->setParameter('externalId', $externalId);

        return $query->getOneOrNullResult();
    }
}