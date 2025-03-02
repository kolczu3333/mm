<?php

namespace App\Tests\Service\Importer;

use App\Service\Importer\RestApiImporter;
use http\Client\Response;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class RestApiImporterTest extends TestCase
{
    /**
     * @throws TransportExceptionInterface
     * @throws Exception
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testFetchProducts(): void
    {
        $httpClient = $this->createMock(HttpClientInterface::class);
        $logger = $this->createMock(LoggerInterface::class);

        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock
            ->method('toArray')
            ->willReturn(
            [
                [
                    'externalId' => '111',
                    'name' => 'Test',
                    'price' => 100.0,
                    'stock' => 10
                ],
                [
                    'externalId' => '112',
                    'name' => 'Test2',
                    'price' => 100.1,
                    'stock' => 12
                ]
            ]
        );

        $httpClient
            ->method('request')
            ->willReturn($responseMock);

        $restApiImporter = new RestApiImporter($httpClient, $logger);
        $products = $restApiImporter->fetchProducts();
        $this->assertIsArray($products);
        $this->assertCount(2, $products);
        $this->assertEquals('111', $products[0]['externalId']);
        $this->assertEquals('Test', $products[0]['name']);
        $this->assertEquals(100.0, $products[0]['price']);
        $this->assertEquals(10, $products[0]['stock']);

        $this->assertEquals('112', $products[1]['externalId']);
        $this->assertEquals('Test2', $products[1]['name']);
        $this->assertEquals(100.1, $products[1]['price']);
        $this->assertEquals(12, $products[1]['stock']);
    }
}
