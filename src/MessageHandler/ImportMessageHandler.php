<?php

namespace App\MessageHandler;

use App\Message\ImportMessage;
use App\Service\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class ImportMessageHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function __invoke(ImportMessage $message): void
    {
        $this->productService->import($message->getSourceType(), $message->getSourcePath());
    }
}