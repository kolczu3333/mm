<?php

namespace App\Tests\Service;


use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\ImporterInterface;
use App\Service\ProductService;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;


class ProductServiceTest extends TestCase
{
    private ProductService $productService;
    private ProductRepository|MockObject $productRepository;
    private ImporterInterface|MockObject $importer;

    /**
     * @throws Exception
     */
    protected function setUp(): void
    {
         $this->productRepository = $this->createMock(ProductRepository::class);
         $this->importer = $this->createMock(ImporterInterface::class);
         $this->productService = new ProductService($this->productRepository);
    }

    public function testImportCreatesNewProduct(): void
    {
        $productData = ['externalId' => '123', 'name' => 'Test Product', 'price' => 19.99, 'stock' => 10];
        $this->productRepository->expects($this->once())
            ->method('findByExternalId')
            ->with('123')
            ->willReturn(null);

        $this->productRepository->expects($this->once())
            ->method('save')
            ->with($this->callback(function (Product $product) use ($productData) {
                return $product->getExternalId() === '123'
                    && $product->getName() === 'Test Product'
                    && $product->getPrice() === 19.99
                    && $product->getStock() === 10;
            }));

        $this->importer->method('fetchProducts')->willReturn([$productData]);
    }
}
