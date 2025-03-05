<?php
require_once(__DIR__ . '/../Views/partials/head.php');
?>
<h1>Création d'un article</h1>
<form method='POST' action="/create" enctype="multipart/form-data">
    <div class="col-md-4 mx-auto d-block mt-5">
        <div class="mb-3">
            <label for="name">Nom de l'article</label>
            <input type="text" name='name' required>
            <?php if (isset($this->arrayError['name'])) { ?>
                <p class='text-danger'><?= $this->arrayError['name'] ?></p>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" required></textarea>
            <?php if (isset($this->arrayError['description'])) { ?>
                <p class='text-danger'><?= $this->arrayError['description'] ?></p>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="price">Prix</label>
            <input type="number" name='price' step="0.01" required>
            <?php if (isset($this->arrayError['price'])) { ?>
                <p class='text-danger'><?= $this->arrayError['price'] ?></p>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="stock">Stock</label>
            <input type="number" name='stock' required>
            <?php if (isset($this->arrayError['stock'])) { ?>
                <p class='text-danger'><?= $this->arrayError['stock'] ?></p>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="category">Catégorie</label>
            <input type="text" name='category' required>
            <?php if (isset($this->arrayError['category'])) { ?>
                <p class='text-danger'><?= $this->arrayError['category'] ?></p>
            <?php } ?>
        </div>
        <div class="mb-3">
            <label for="image">Image de l'article</label>
            <input type="file" name="image" accept="image/*" required>
            <?php if (isset($this->arrayError['image'])) { ?>
                <p class='text-danger'><?= $this->arrayError['image'] ?></p>
            <?php } ?>
        </div>
        <button type="submit" class='btn btn-success mt-5 mb-5'>Ajouter l'article</button>
    </div>
</form>

<?php
require_once(__DIR__ . '/../Views/partials/footer.php');
?>
