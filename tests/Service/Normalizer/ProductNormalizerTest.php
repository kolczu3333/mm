<?php

namespace App\Tests\Service\Normalizer;

use App\Dto\ProductDto;
use App\Service\Normalizer\ProductNormalizer;
use PHPUnit\Framework\TestCase;

class ProductNormalizerTest extends TestCase
{
    public function testNormalize(): void
    {
        $normalizer = new ProductNormalizer();

        $inputData = [
            'externalId' => ' 111 ',
            'name' => '<b> Test </b>',
            'price' => '100,99',
            'stock' => '-5'
        ];

        $dto = $normalizer->normalize($inputData);

        $this->assertInstanceOf(ProductDto::class, $dto);
        $this->assertEquals('111', $dto->externalId);
        $this->assertEquals('Test', $dto->name);
        $this->assertEquals(100.99, $dto->price);
        $this->assertEquals(0, $dto->stock);
    }
}
