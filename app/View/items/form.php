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

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">
            IT-Expect
        </a>
    </div>
</nav>

<main class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des items</h1>

        <a href="/items/create" class="btn btn-primary">
            + Ajouter un item
        </a>
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

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>