<?php

namespace Controller;

use Model\ItemRepository;

class ItemController
{
    private ItemRepository $repository;

    public function __construct()
    {
        $this->repository = new ItemRepository();
    }

    public function index(): void
    {
        $items = $this->repository->findAll();

        require __DIR__ . '/../View/items/form.php';
    }
}
