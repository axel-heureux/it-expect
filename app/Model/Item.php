<?php

namespace Model;

class Item
{
    private ?int $id = null;
    private string $name = '';
    private float $price = 0.0;
    private int $stock = 0;
    private ?string $createdAt = null;

    /**
     * Hydrate l'entité avec un tableau de données.
     */
    public function hydrate(array $data): self
    {
        if (isset($data['id'])) {
            $this->setId((int) $data['id']);
        }

        if (isset($data['name'])) {
            $this->setName($data['name']);
        }

        if (isset($data['price'])) {
            $this->setPrice((float) $data['price']);
        }

        if (isset($data['stock'])) {
            $this->setStock((int) $data['stock']);
        }

        if (isset($data['created_at'])) {
            $this->setCreatedAt($data['created_at']);
        }

        return $this;
    }

    // -------------------------
    // Getters
    // -------------------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    // -------------------------
    // Setters
    // -------------------------

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

        return $this;
    }

    public function setCreatedAt(?string $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}