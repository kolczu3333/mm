<?php

namespace App\Message;
class ImportMessage
{
    public function __construct(
        public string $sourceType,
        public string $sourcePath
    )
    {
    }
}