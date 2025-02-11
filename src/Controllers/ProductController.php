<?php


namespace App\Controllers;



use App\Models\Product;
use PDO;



class ProductController {
    
    private Product $productModel;

    public function __construct(PDO $pdo) {
        $this->productModel = new Product($pdo);
    }
    

    public function createProduct(): array {
        $name = $_POST['name'] ?? '';
        $description = htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES);
        $price = $_POST['price'] ?? '';
        $stock = $_POST['stock'] ?? '';
        $category = $_POST['category'] ?? '';
        $image = $_POST['image'] ?? '';

        if (!$name || !is_numeric($stock) || $stock < 0 || !$category) {
            return [["success" => false, "text" => "Veuillez remplir correctement tous les champs."]];
        }

        $this->productModel->create($name, $description, $price, $stock, $category, $image);
        return [["success" => true, "text" => "Produit ajouté avec succès."]];
    }

    public function readOneProduct(): ?array {
        return is_numeric($_GET['id'] ?? '') ? $this->productModel->readOne($_GET['id']) : null;
    }

    public function readAllProducts(): array {
        return $this->productModel->readAll();
    }

    public function updateProduct(): array {
        if (empty($_POST['submit']) || !is_numeric($_GET['id'] ?? '')) return [];

        $id = $_GET['id'];
        $name = $_POST['name'] ?? '';
        $description = htmlspecialchars($_POST['description'] ?? '', ENT_QUOTES);
        $price = $_POST['price'] ?? '';
        $stock = $_POST['stock'] ?? '';
        $category = $_POST['category'] ?? '';

        if (!$name || !is_numeric($stock) || $stock < 0 || !$category) {
            return [["success" => false, "text" => "Veuillez remplir correctement tous les champs."]];
        }

        $this->productModel->update($id, $name, $description, $price, $stock, $category);
        return [["success" => true, "text" => "Produit mis à jour avec succès."]];
    }

    public function deleteProduct(): void {
        if (is_numeric($_GET['id'] ?? '')) {
            $this->productModel->delete($_GET['id']);
        }
    }
}
