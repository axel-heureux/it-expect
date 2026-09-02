<?php

namespace Controller;

use Core\Validator;
use Model\Item;
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
        $errors = [];
        $old = [];
        $showCreateModal = false;

        require __DIR__ . '/../View/items/form.php';
    }

    public function create(): void
    {
        $errors = [];
        $old = [];

        require __DIR__ . '/../View/items/create.php';
    }

    public function store(): void
    {
        $data = [
            'name' => $_POST['name'] ?? '',
            'price' => $_POST['price'] ?? '',
            'stock' => $_POST['stock'] ?? '',
        ];

        $validator = new Validator();

        $isValid = $validator->validate($data, [
            'name' => ['required', 'maxLength:100'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
        ]);

        if (!$isValid) {
            $errors = $validator->errors();
            $old = $data;
            $items = $this->repository->findAll();
            $showCreateModal = true;

            require __DIR__ . '/../View/items/form.php';
            return;
        }

        $item = (new Item())->hydrate([
            'name' => $data['name'],
            'price' => (float) $data['price'],
            'stock' => (int) $data['stock'],
        ]);

        $this->repository->save($item);
        $items = $this->repository->findAll();
        $errors = [];
        $old = [];
        $showCreateModal = false;
        $success = 'L\'item a bien été ajouté.';

        require __DIR__ . '/../View/items/form.php';
    }
}