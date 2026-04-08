<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="admin-wrapper">

    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-logo">
            <img src="<?= $baseUrl ?>/public/img/logo.png" alt="FitGym">
            <span>Admin Panel</span>
        </div>
        <nav class="admin-nav">
            <a href="<?= $baseUrl ?>/admin" class="admin-nav-link active">
                <i class="fa-solid fa-gauge"></i> Dashboard
            </a>
            <a href="<?= $baseUrl ?>/listUsers" class="admin-nav-link">
                <i class="fa-solid fa-users"></i> Utilisateurs
            </a>
            <a href="<?= $baseUrl ?>/products" class="admin-nav-link">
                <i class="fa-solid fa-box"></i> Produits
            </a>
            <a href="<?= $baseUrl ?>/createProduct" class="admin-nav-link">
                <i class="fa-solid fa-plus"></i> Ajouter un produit
            </a>
            <a href="<?= $baseUrl ?>/logout" class="admin-nav-link admin-nav-logout">
                <i class="fa-solid fa-power-off"></i> Déconnexion
            </a>
        </nav>
    </aside>

    <!-- Contenu principal -->
    <main class="admin-main">

        <div class="admin-topbar">
            <h1>Tableau de bord</h1>
            <span class="admin-user-badge">
                <i class="fa-solid fa-user-shield"></i>
                <?= htmlspecialchars($_SESSION['user']['username'] . ' ' . $_SESSION['user']['lastName']) ?>
            </span>
        </div>

        <!-- Cartes de statistiques -->
        <div class="admin-stats">
            <div class="admin-stat-card admin-stat-products">
                <div class="admin-stat-icon"><i class="fa-solid fa-box"></i></div>
                <div class="admin-stat-info">
                    <span class="admin-stat-number"><?= $nbProducts ?></span>
                    <span class="admin-stat-label">Produits</span>
                </div>
            </div>
            <div class="admin-stat-card admin-stat-users">
                <div class="admin-stat-icon"><i class="fa-solid fa-users"></i></div>
                <div class="admin-stat-info">
                    <span class="admin-stat-number"><?= $nbUsers ?></span>
                    <span class="admin-stat-label">Utilisateurs</span>
                </div>
            </div>
            <div class="admin-stat-card admin-stat-reviews">
                <div class="admin-stat-icon"><i class="fa-solid fa-star"></i></div>
                <div class="admin-stat-info">
                    <span class="admin-stat-number"><?= $nbReviews ?></span>
                    <span class="admin-stat-label">Avis</span>
                </div>
            </div>
            <div class="admin-stat-card admin-stat-add">
                <a href="<?= $baseUrl ?>/createProduct" class="admin-stat-add-link">
                    <div class="admin-stat-icon"><i class="fa-solid fa-plus-circle"></i></div>
                    <div class="admin-stat-info">
                        <span class="admin-stat-label">Ajouter un produit</span>
                    </div>
                </a>
            </div>
        </div>

        <!-- Tableaux récents -->
        <div class="admin-tables">

            <!-- Derniers produits -->
            <div class="admin-table-block">
                <div class="admin-table-header">
                    <h2><i class="fa-solid fa-box"></i> Derniers produits</h2>
                    <a href="<?= $baseUrl ?>/products" class="admin-table-link">Voir tout</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestProducts as $p): ?>
                        <tr>
                            <td><?= htmlspecialchars($p['name']) ?></td>
                            <td><span class="admin-badge"><?= htmlspecialchars($p['category'] ?? '-') ?></span></td>
                            <td><?= number_format($p['price'], 2, ',', ' ') ?> €</td>
                            <td>
                                <span class="admin-stock <?= $p['stock'] <= 5 ? 'admin-stock-low' : '' ?>">
                                    <?= $p['stock'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?= $baseUrl ?>/editProduct?id=<?= $p['id'] ?>" class="admin-btn admin-btn-edit"><i class="fa-solid fa-pen"></i></a>
                                <a href="<?= $baseUrl ?>/deleteProduct?id=<?= $p['id'] ?>" class="admin-btn admin-btn-delete" onclick="return confirm('Supprimer ce produit ?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Derniers utilisateurs -->
            <div class="admin-table-block">
                <div class="admin-table-header">
                    <h2><i class="fa-solid fa-users"></i> Derniers inscrits</h2>
                    <a href="<?= $baseUrl ?>/listUsers" class="admin-table-link">Voir tout</a>
                </div>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Inscrit le</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($latestUsers as $u): ?>
                        <tr>
                            <td><?= htmlspecialchars($u['username'] . ' ' . $u['lastName']) ?></td>
                            <td><?= htmlspecialchars($u['email']) ?></td>
                            <td>
                                <span class="admin-role <?= $u['id_Role'] == 1 ? 'admin-role-admin' : 'admin-role-user' ?>">
                                    <?= $u['id_Role'] == 1 ? 'Admin' : 'Utilisateur' ?>
                                </span>
                            </td>
                            <td><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                            <td>
                                <a href="<?= $baseUrl ?>/editUser?id=<?= $u['id'] ?>" class="admin-btn admin-btn-edit"><i class="fa-solid fa-pen"></i></a>
                                <?php if ($u['id'] != $_SESSION['user']['id']): ?>
                                <a href="<?= $baseUrl ?>/deleteUser?id=<?= $u['id'] ?>" class="admin-btn admin-btn-delete" onclick="return confirm('Supprimer cet utilisateur ?')"><i class="fa-solid fa-trash"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>
