<?php

namespace Tests\Integration\Core;

use Core\Database;
use PDO;
use PHPUnit\Framework\TestCase;

class CardDatabaseTest extends TestCase
{
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->pdo = Database::getConnection();
        $this->pdo->exec('TRUNCATE TABLE items');
    }

    public function countItems(): int
    {
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM items');

        return (int) $stmt->fetchColumn();
    }

    public function testItemsTableStartsEmpty(): void
    {
        $this->assertSame(0, $this->countItems());
    }
}