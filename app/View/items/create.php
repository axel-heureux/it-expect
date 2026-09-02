<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Ajouter un item</title>

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
        <h1>Ajouter un item</h1>

        <a href="/" class="btn btn-outline-secondary">
            &larr; Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-md-8 col-lg-6">

            <form action="/items/store" method="POST" novalidate>

                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($old['name'] ?? '') ?>"
                    >
                    <?php foreach ($errors['name'] ?? [] as $error): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Prix (€)</label>
                    <input
                        type="text"
                        id="price"
                        name="price"
                        class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($old['price'] ?? '') ?>"
                    >
                    <?php foreach ($errors['price'] ?? [] as $error): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input
                        type="text"
                        id="stock"
                        name="stock"
                        class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>"
                        value="<?= htmlspecialchars($old['stock'] ?? '') ?>"
                    >
                    <?php foreach ($errors['stock'] ?? [] as $error): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="submit" class="btn btn-primary">
                    Enregistrer
                </button>

            </form>

        </div>
    </div>

</main>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>