<?php

namespace App\Message;
class ImportMessage
{
    public function __construct(private string $sourceType, private string $sourcePath)
    {
    }
    public function getSourceType(): string { return $this->sourceType; }
    public function getSourcePath(): string { return $this->sourcePath; }
}