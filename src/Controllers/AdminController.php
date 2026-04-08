<?php

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;
use Config\Database;

class AdminController extends AbstractController
{
    private function requireAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['id_Role'] != 1) {
            $this->redirectToRoute('/');
        }
    }

    public function dashboard()
    {
        $this->requireAdmin();

        $pdo = Database::getInstance()->getConnection();

        $nbProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
        $nbUsers    = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        $nbReviews  = $pdo->query("SELECT COUNT(*) FROM reviews")->fetchColumn();

        $latestUsers = $pdo->query(
            "SELECT id, username, lastName, email, id_Role, created_at FROM users ORDER BY created_at DESC LIMIT 5"
        )->fetchAll(\PDO::FETCH_ASSOC);

        $latestProducts = $pdo->query(
            "SELECT id, name, price, stock, category FROM products ORDER BY id DESC LIMIT 5"
        )->fetchAll(\PDO::FETCH_ASSOC);

        require_once(__DIR__ . "/../Views/admin.view.php");
    }

    public function manageUsers()
    {
        $this->requireAdmin();
        $users = User::getAll();
        require_once(__DIR__ . "/../Views/admin.users.view.php");
    }

    public function updateRole()
    {
        $this->requireAdmin();

        if (isset($_POST['user_id'], $_POST['role'])) {
            $userId  = intval($_POST['user_id']);
            $newRole = intval($_POST['role']);
            User::updateRole($userId, $newRole);
        }

        $this->redirectToRoute('/admin');
    }
}