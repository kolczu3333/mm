<?php

namespace App\Service\Importer;

use App\Service\ImporterInterface;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

readonly class RestApiImporter implements ImporterInterface
{
    public function __construct(private HttpClientInterface $httpClient, private LoggerInterface $logger)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetchProducts(): array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://api.example.com/products');

            return $response->toArray();
        } catch (Exception $e) {
            $this->logger->error('Błąd pobierania danych: ' . $e->getMessage());

            return [];
        }
    }
}