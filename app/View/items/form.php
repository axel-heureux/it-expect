<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Mes Items</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<?php
$baseUrl = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$baseUrl = $baseUrl === '/' ? '' : $baseUrl;
?>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= $baseUrl ?>/">
            IT-Expect
        </a>
    </div>
</nav>

<main class="container">

    <?php if (!empty($success)): ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des items</h1>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createItemModal">
            + Ajouter un item
        </button>
    </div>

    <?php if (empty($items)): ?>

        <div class="alert alert-info">
            Aucun item trouvé.
        </div>

    <?php else: ?>

        <div class="row g-4">

            <?php foreach ($items as $item): ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm">

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= htmlspecialchars($item->getName()) ?>
                            </h5>

                            <p class="card-text">
                                <strong><?= number_format($item->getPrice(), 2, ',', ' ') ?> €</strong>
                            </p>

                            <p class="card-text text-muted">
                                Stock :
                                <?php if ($item->getStock() > 0): ?>
                                    <?= $item->getStock() ?> unité(s)
                                <?php else: ?>
                                    <span class="text-danger">Rupture de stock</span>
                                <?php endif; ?>
                            </p>

                        </div>

                        <div class="card-footer bg-white border-0">
                            <small class="text-muted">
                                ID : <?= $item->getId() ?>
                                <?php if ($item->getCreatedAt()): ?>
                                    &middot; Ajouté le
                                    <?= (new DateTime($item->getCreatedAt()))->format('d/m/Y') ?>
                                <?php endif; ?>
                            </small>
                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</main>

<div class="modal fade" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="createItemModalLabel">Ajouter un item</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <form action="<?= $baseUrl ?>/" method="POST" novalidate>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" id="name" name="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($old['name'] ?? '') ?>">
                        <?php foreach ($errors['name'] ?? [] as $error): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label">Prix (€)</label>
                        <input type="text" id="price" name="price" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($old['price'] ?? '') ?>">
                        <?php foreach ($errors['price'] ?? [] as $error): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>

                    <div class="mb-3">
                        <label for="stock" class="form-label">Stock</label>
                        <input type="text" id="stock" name="stock" class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($old['stock'] ?? '') ?>">
                        <?php foreach ($errors['stock'] ?? [] as $error): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

<?php if ($showCreateModal ?? false): ?>
<script>
    new bootstrap.Modal(document.getElementById('createItemModal')).show();
</script>
<?php endif; ?>

</body>
</html>