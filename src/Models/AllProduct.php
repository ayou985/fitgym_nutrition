<?php

namespace App\Models;

use Config\Database;
use PDO;

class AllProduct
{
    private ?int $id;
    private ?string $name;
    private ?string $description;
    private ?float $price;
    private ?int $stock;
    private ?string $category;
    private ?string $image;
    private ?string $comment;
    private ?int $rating;
    private ?int $user_id;

    public function __construct(
        ?int $id = null,
        ?string $name = null,
        ?string $description = null,
        ?float $price = null,
        ?int $stock = null,
        ?string $category = null,
        ?string $image = null,
        ?string $comment = null,
        ?int $rating= null,
        ?int $user_id= null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
        $this->image = $image;
        $this->comment = $comment;
        $this->rating = $rating;
        $this->user_id = $user_id;
    }

    // 🔹 **Getters**
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    // 🔹 **Setters**
    public function setId(?int $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function setPrice(?float $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;
        return $this;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;
        return $this;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;
        return $this;
    }

    // 🔹 **Récupérer un produit par son ID**
    public static function getById(int $id): ?AllProduct
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        $sql = "SELECT * FROM product WHERE id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new AllProduct(
            $row['id'],
            $row['name'],
            $row['description'],
            $row['price'],
            $row['stock'],
            $row['category'],
            $row['image']
        );
    }

    // 🔹 **Récupérer tous les produits**
    public static function getAll(): array
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        $sql = "SELECT * FROM product";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $products = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $products[] = new AllProduct(
                $row['id'],
                $row['name'],
                $row['description'],
                $row['price'],
                $row['stock'],
                $row['category'],
                $row['image']
            );
        }

        return $products;
    }

    public function edit()
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        // Vérifier si une image est bien fournie
        if (empty($this->image)) {
            $this->image = 'default.jpg'; // Mettre une image par défaut
        }

        if ($this->id) {
            $sql = "UPDATE product SET name = ?, description = ?, price = ?, stock = ?, category = ?, image = ? WHERE id = ?";
            $statement = $pdo->prepare($sql);
            return $statement->execute([
                $this->name,
                $this->description,
                $this->price,
                $this->stock,
                $this->category,
                $this->image,
                $this->id
            ]);
        }
    }

    public function createProduct()
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO product (name, description, price, stock, category, image) VALUES (?, ?, ?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([
            $this->name,
            $this->description,
            $this->price,
            $this->stock,
            $this->category,
            $this->image
        ]);
    }

    public function addComment()
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();
        $sql = "INSERT INTO reviews (id,comment, rating, user_id,product_id) VALUES ( ?,?, ?, ?, ?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([
            null,
            $this->comment,
            $this->rating,
            $this->user_id,
            $this->id
        ]);
    }
    public function delete(): bool
    {
        $db = Database::getInstance();
        $pdo = $db->getConnection();

        $sql = "DELETE FROM product WHERE id = ?";
        $statement = $pdo->prepare($sql);

        if ($statement->execute([$this->id])) {
            return true;
        } else {
            error_log("Erreur SQL : " . implode(" | ", $statement->errorInfo()));
            return false;
        }
    }

    public static function userHasReviewed($userId, $product_id)
    {
        $db = Database::getInstance()->getConnection(); // Ensure $db is a PDO instance
        $query = $db->prepare("SELECT COUNT(*) FROM reviews WHERE user_id = ? AND product_id = ?");
        $query->execute([$userId, $product_id]);
        return $query->fetchColumn() > 0;
    }

    public static function createReviews($comment, $rating, $created_at, $user_id, $product_id)
    {
        $db = Database::getInstance()->getConnection();
    
        // Vérification des paramètres avant d'exécuter la requête
        if (empty($user_id) || empty($product_id) || empty($comment) || $rating < 1 || $rating > 5) {
            throw new \Exception("Paramètres invalides pour createReviews");
        }
    
        // Si la date n’est pas passée en paramètre, utilisez la date actuelle
        if (empty($created_at)) {
            $created_at = date('Y-m-d H:i:s');
        }
    
        // Préparation de la requête SQL
        $sql = "INSERT INTO reviews (comment, rating, user_id, created_at, product_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
    
        // Exécution de la requête avec les paramètres
        $stmt->execute([$comment, $rating, $user_id, $created_at, $product_id]);
    }



    public static function getReviewsByProductId($productId) {
        $db = Database::getInstance()->getConnection();
        $query = $db->prepare("
            SELECT r.comment, r.rating, r.created_at, u.firstname, u.lastname
            FROM reviews r
            JOIN user u ON r.user_id = u.id
            WHERE r.product_id = ?
            ORDER BY r.created_at DESC
        ");
        $query->execute([$productId]);
        return $query->fetchAll();
    }

    public static function updateReviews($id, $comment, $rating)
    {
        $db = Database::getInstance()->getConnection();
        $sql = "UPDATE reviews SET comment = ?, rating = ? WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$comment, $rating, $id]);
    }
    
    public static function deleteReviews($id)
    {
        $db = Database::getInstance()->getConnection();
        $sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id]);
    }
    
}
