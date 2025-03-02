<?php

namespace App\Tests\Service\Importer;

use App\Service\Importer\XmlImporter;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;


class XmlImporterTest extends TestCase
{
    private string $validXmlPath;
    private string $invalidXmlPath;
    private LoggerInterface $logger;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->validXmlPath = tempnam(sys_get_temp_dir(),'xml');
        file_put_contents($this->validXmlPath, <<<XML
<products>
    <product>
        <id>123</id>
        <name>Test Product</name>
        <price>98.12</price>
        <stock>10</stock>
    </product>
</products>
XML);

        $this->invalidXmlPath = tempnam(sys_get_temp_dir(), 'xml');
        file_put_contents($this->invalidXmlPath, <<<XML
<products>
    <product>
        <id>112</id>
        <name>Test2</name>
        <price>98.13</price>
        <stock>10
    </product>
</products>
XML);
        $this->logger = $this->createMock(LoggerInterface::class);
    }

    public function testFetchProductsValidXml(): void
    {
        $importer = new XmlImporter($this->validXmlPath, $this->logger);
        $products = $importer->fetchProducts();
        $this->assertIsArray($products);
        $this->assertCount(1, $products);
        $this->assertEquals('123', $products[0]['externalId']);
        $this->assertEquals('Test Product', $products[0]['name']);
        $this->assertEquals(98.12, $products[0]['price']);
        $this->assertEquals(10, $products[0]['stock']);
    }

    public function testFetchProductsInvalidXml(): void
    {
        $this->logger
            ->expects($this->once())
            ->method('error')
            ->with($this->stringContains('Błąd parsowania XML'));

        $importer = new XmlImporter($this->invalidXmlPath, $this->logger);
        $products = $importer->fetchProducts();

        $this->assertIsArray($products);
        $this->assertEmpty($products);
    }

    protected function tearDown(): void
    {
        @unlink($this->validXmlPath);
        @unlink($this->invalidXmlPath);
    }
}
