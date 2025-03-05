<?php
// Assurez-vous que l'utilisateur est bien authentifié avant de pouvoir accéder à cette page
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Inclusion des fichiers nécessaires
require_once '../includes/head.php'; // Inclure l'entête de la page
require_once '../../src/Models/Product.php'; // Inclure le modèle de produit

// Récupérer l'ID du produit à supprimer
$productId = isset($_GET['id']) ? $_GET['id'] : null;
$product = null;

// Vérifier si un ID de produit est passé et récupérer les informations du produit
if ($productId) {
    $product = $productId::getProductById($productId);
}

// Si le produit n'existe pas, rediriger vers la liste des produits
if (!$product) {
    echo "<p>Produit non trouvé.</p>";
    exit();
}

?>

<div class="container">
    <h1>Supprimer le produit</h1>

    <p>Êtes-vous sûr de vouloir supprimer le produit suivant ?</p>

    <div class="product-details">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <p><strong>Prix:</strong> <?php echo htmlspecialchars($product['price']); ?> €</p>
        <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
    </div>

    <form action="/delete?id=<?= $product->getId(); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product->getId(); ?>">

        <div class="product-details">
            <h2>Êtes-vous sûr de vouloir supprimer ce produit ?</h2>
            <p><strong>Nom :</strong> <?= htmlspecialchars($product->getName()); ?></p>
            <p><strong>Description :</strong> <?= htmlspecialchars($product->getDescription()); ?></p>
            <p><strong>Prix :</strong> <?= $product->getPrice(); ?> €</p>
            <p><strong>Stock :</strong> <?= $product->getStock(); ?></p>
            <p><strong>Catégorie :</strong> <?= htmlspecialchars($product->getCategory()); ?></p>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-danger">Supprimer</button>
            <a href="admin.product.list.view.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>

</div>

<?php
require_once '../includes/footer.php'; // Inclure le pied de page
?>