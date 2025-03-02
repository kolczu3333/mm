<?php

namespace App\Tests\Service\Normalizer;

use App\Service\Normalizer\ProductNormalizer;
use PHPUnit\Framework\TestCase;

class ProductNormalizerTest extends TestCase
{
    public function testFetchProducts(): void
    {
        $normalizer = new ProductNormalizer();

        $inputData = [
            'externalId' => ' 111 ',
            'name' => '<b> Test </b>',
            'price' => '100,99',
            'stock' => '-5'
        ];

        $expectedOutput = [
            'externalId' => '111',
            'name' => 'Test',
            'price' => 100.99,
            'stock' => 0
        ];

        $this->assertEquals($expectedOutput, $normalizer->normalize($inputData));
    }
}
