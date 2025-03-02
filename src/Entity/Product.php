<?php

namespace App\Entity;

use Doctrine\Orm\Mapping as ORM;

#[ORM\Entity(repositoryClass: "App\Repository\ProductRepository")]
class Product
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type:"integer")]
    private int $id;
    #[ORM\Column(type:"string")]
    private string $name;
    #[ORM\Column(type:"decimal", precision:10, scale:2)]
    private float $price;
    #[ORM\Column(type:"integer")]
    private int $stock;
    #[ORM\Column(type:"string", length: 255, unique:true)]
    private string $externalId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function getExternalId(): string
    {
        return $this->externalId;
    }

    public function setExternalId(string $externalId): void
    {
        $this->externalId = $externalId;
    }
}