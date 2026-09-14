<?php

namespace Tests\Integration\Model;

use Core\Database;
use Model\Item;
use Model\ItemRepository;
use PDO;
use PHPUnit\Framework\TestCase;

class ItemRepositoryTest extends TestCase
{
    private PDO $pdo;
    private ItemRepository $repository;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->pdo->exec('TRUNCATE TABLE items');
        $this->repository = new ItemRepository();
    }

    public function testSaveFindByIdAndFindAll(): void
    {
        $item = $this->repository->save(
            (new Item())->setName('Clavier')->setPrice(49.90)->setStock(10)
        );

        $found = $this->repository->findById($item->getId());

        $this->assertNotNull($found);
        $this->assertSame('Clavier', $found->getName());
        $this->assertCount(1, $this->repository->findAll());
    }

    public function testSaveUpdatesExistingItem(): void
    {
        $item = $this->repository->save(
            (new Item())->setName('Ancien nom')->setPrice(10)->setStock(1)
        );
        $item->setName('Nouveau nom')->setPrice(20)->setStock(3);

        $this->repository->save($item);

        $updated = $this->repository->findById($item->getId());
        $this->assertSame('Nouveau nom', $updated->getName());
        $this->assertSame(20.0, $updated->getPrice());
        $this->assertSame(3, $updated->getStock());
    }

    public function testDeleteByIdRemovesItem(): void
    {
        $item = $this->repository->save(
            (new Item())->setName('A supprimer')->setPrice(1)->setStock(0)
        );

        $this->assertTrue($this->repository->deleteById($item->getId()));
        $this->assertNull($this->repository->findById($item->getId()));
    }
}