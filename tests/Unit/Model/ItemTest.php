<?php

namespace Tests\Unit\Model;

use Model\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function testHydratePopulatesAndNormalizesItem(): void
    {
        $item = (new Item())->hydrate([
            'id' => 4,
            'name' => '  Clavier  ',
            'price' => '49.90',
            'stock' => '10',
            'created_at' => '2026-09-14 10:00:00',
        ]);

        $this->assertSame(4, $item->getId());
        $this->assertSame('Clavier', $item->getName());
        $this->assertSame(49.90, $item->getPrice());
        $this->assertSame(10, $item->getStock());
        $this->assertSame('2026-09-14 10:00:00', $item->getCreatedAt());
    }

    public function testSettersUpdateItemValues(): void
    {
        $item = (new Item())
            ->setId(1)
            ->setName('Souris')
            ->setPrice(19.99)
            ->setStock(5);

        $this->assertSame(1, $item->getId());
        $this->assertSame('Souris', $item->getName());
        $this->assertSame(19.99, $item->getPrice());
        $this->assertSame(5, $item->getStock());
    }
}