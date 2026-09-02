<?php

namespace Model;

use Core\Database;
use PDO;

class ItemRepository
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    /**
     * Récupère tous les items.
     *
     * @return Item[]
     */
    public function findAll(): array
    {
        $sql = '
            SELECT id, name, price, stock, created_at
            FROM items
            ORDER BY id DESC
        ';

        $stmt = $this->pdo->query($sql);

        $items = [];

        while ($data = $stmt->fetch()) {
            $items[] = (new Item())->hydrate($data);
        }

        return $items;
    }

    /**
     * Récupère un item par son ID.
     */
    public function findById(int $id): ?Item
    {
        $sql = '
            SELECT id, name, price, stock, created_at
            FROM items
            WHERE id = :id
        ';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return (new Item())->hydrate($data);
    }

    /**
     * Crée un nouvel item ou met à jour un item existant.
     */
    public function save(Item $item): Item
    {
        // INSERT
        if ($item->getId() === null) {
            $sql = '
                INSERT INTO items (name, price, stock)
                VALUES (:name, :price, :stock)
            ';

            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                'name' => $item->getName(),
                'price' => $item->getPrice(),
                'stock' => $item->getStock()
            ]);

            $item->setId(
                (int) $this->pdo->lastInsertId()
            );

            return $item;
        }

        // UPDATE
        $sql = '
            UPDATE items
            SET name = :name,
                price = :price,
                stock = :stock
            WHERE id = :id
        ';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'id' => $item->getId(),
            'name' => $item->getName(),
            'price' => $item->getPrice(),
            'stock' => $item->getStock()
        ]);

        return $item;
    }
}