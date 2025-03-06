<?php
require_once(__DIR__ . '/../Views/partials/head.php');
?>

<h1>Modification d'un article</h1>
<form method="POST" action="/updateProduct?id=<?= $product['id']; ?>" enctype="multipart/form-data">
    <div class="col-md-4 mx-auto d-block mt-5">
        <input type="hidden" name="id" value="<?= $product['id']; ?>">

        <div class="mb-3">
            <label for="name">Nom de l'article</label>
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>
            <?php if (isset($this->arrayError['name'])) { ?>
                <p class="text-danger"><?= $this->arrayError['name'] ?></p>
            <?php } ?>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" required><?= htmlspecialchars($product['description']); ?></textarea>
            <?php if (isset($this->arrayError['description'])) { ?>
                <p class="text-danger"><?= $this->arrayError['description'] ?></p>
            <?php } ?>
        </div>

        <div class="mb-3">
            <label for="price">Prix</label>
            <input type="number" name="price" value="<?= $product['price']; ?>" step="0.01" required>
            <?php if (isset($this->arrayError['price'])) { ?>
                <p class="text-danger"><?= $this->arrayError['price'] ?></p>
            <?php } ?>
        </div>

        <div class="mb-3">
            <label for="stock">Stock</label>
            <input type="number" name="stock" value="<?= $product['stock']; ?>" required>
            <?php if (isset($this->arrayError['stock'])) { ?>
                <p class="text-danger"><?= $this->arrayError['stock'] ?></p>
            <?php } ?>
        </div>

        <div class="mb-3">
            <label for="category">Catégorie</label>
            <input type="text" name="category" value="<?= htmlspecialchars($product['category']); ?>" required>
            <?php if (isset($this->arrayError['category'])) { ?>
                <p class="text-danger"><?= $this->arrayError['category'] ?></p>
            <?php } ?>
        </div>

        <div class="mb-3">
            <label for="image">Image de l'article (facultatif)</label>
            <input type="file" name="image" accept="image/*">
            <?php if (isset($this->arrayError['image'])) { ?>
                <p class="text-danger"><?= $this->arrayError['image'] ?></p>
            <?php } ?>
        </div>

        <button type="submit" class="btn btn-primary mt-5 mb-5">Mettre à jour l'article</button>
    </div>
</form>

<?php
require_once(__DIR__ . '/../Views/partials/footer.php');
?>
