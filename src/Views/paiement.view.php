<?php
require_once(__DIR__ . "/partials/head.php");

use App\Controllers\CartController;

$cartData  = CartController::getCartItems();
$cartItems = $cartData['items'];
$total     = $cartData['total'];

// Pré-remplir depuis la session
$userName    = isset($_SESSION['user']) ? htmlspecialchars(($_SESSION['user']['username'] ?? '') . ' ' . ($_SESSION['user']['lastName'] ?? '')) : '';
$userAddress = isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']['address'] ?? '') : '';
?>

<div class="checkout-page">

    <?php if (isset($_SESSION['success'])): ?>
        <div class="checkout-success-banner">
            <i class="fa-solid fa-circle-check"></i>
            <?= htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8') ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($cartItems)): ?>

    <div class="checkout-wrapper">

        <!-- Colonne gauche : formulaire -->
        <div class="checkout-left">

            <!-- Étapes -->
            <div class="checkout-steps">
                <div class="checkout-step active">
                    <span class="step-number">1</span>
                    <span class="step-label">Livraison</span>
                </div>
                <div class="checkout-step-line"></div>
                <div class="checkout-step active">
                    <span class="step-number">2</span>
                    <span class="step-label">Paiement</span>
                </div>
                <div class="checkout-step-line"></div>
                <div class="checkout-step">
                    <span class="step-number">3</span>
                    <span class="step-label">Confirmation</span>
                </div>
            </div>

            <form action="<?= $baseUrl ?>/paiement/process" method="POST" id="checkout-form">

                <!-- Section livraison -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">
                        <i class="fa-solid fa-truck"></i> Adresse de livraison
                    </h2>

                    <div class="checkout-field-row">
                        <div class="checkout-field">
                            <label for="name">Nom complet</label>
                            <input type="text" id="name" name="name" class="checkout-input"
                                   value="<?= $userName ?>" placeholder="Jean Dupont" required>
                        </div>
                    </div>

                    <div class="checkout-field">
                        <label for="address">Adresse</label>
                        <input type="text" id="address" name="address" class="checkout-input"
                               value="<?= $userAddress ?>" placeholder="12 rue des Athlètes" required>
                    </div>

                    <div class="checkout-field-row">
                        <div class="checkout-field">
                            <label for="city">Ville</label>
                            <input type="text" id="city" name="city" class="checkout-input" placeholder="Paris" required>
                        </div>
                        <div class="checkout-field">
                            <label for="zip">Code postal</label>
                            <input type="text" id="zip" name="zip" class="checkout-input" placeholder="75001" maxlength="5" required>
                        </div>
                    </div>
                </div>

                <!-- Section paiement -->
                <div class="checkout-section">
                    <h2 class="checkout-section-title">
                        <i class="fa-solid fa-credit-card"></i> Informations de paiement
                    </h2>

                    <div class="checkout-card-icons">
                        <img src="<?= $baseUrl ?>/public/img/visa.png" alt="Visa" onerror="this.style.display='none'">
                        <img src="<?= $baseUrl ?>/public/img/mastercard.png" alt="Mastercard" onerror="this.style.display='none'">
                        <span class="checkout-card-label"><i class="fa-brands fa-cc-visa"></i></span>
                        <span class="checkout-card-label"><i class="fa-brands fa-cc-mastercard"></i></span>
                        <span class="checkout-card-label"><i class="fa-brands fa-cc-paypal"></i></span>
                    </div>

                    <div class="checkout-field">
                        <label for="card_number">Numéro de carte</label>
                        <div class="checkout-input-icon">
                            <i class="fa-solid fa-credit-card"></i>
                            <input type="text" id="card_number" class="checkout-input"
                                   placeholder="1234 5678 9012 3456"
                                   maxlength="19" autocomplete="off" required>
                        </div>
                    </div>

                    <div class="checkout-field-row">
                        <div class="checkout-field">
                            <label for="expiry">Date d'expiration</label>
                            <input type="text" id="expiry" class="checkout-input"
                                   placeholder="MM / AA" maxlength="7" required>
                        </div>
                        <div class="checkout-field">
                            <label for="cvv">CVV</label>
                            <div class="checkout-input-icon">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" id="cvv" class="checkout-input"
                                       placeholder="•••" maxlength="3" autocomplete="off" required>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-field">
                        <label for="card_name">Nom sur la carte</label>
                        <input type="text" id="card_name" class="checkout-input"
                               placeholder="JEAN DUPONT" required>
                    </div>
                </div>

                <button type="submit" class="checkout-submit">
                    <i class="fa-solid fa-lock"></i>
                    Payer <?= number_format($total, 2, ',', ' ') ?> €
                </button>

                <p class="checkout-secure-note">
                    <i class="fa-solid fa-shield-halved"></i>
                    Paiement simulé — aucune donnée bancaire n'est enregistrée
                </p>

            </form>
        </div>

        <!-- Colonne droite : récapitulatif commande -->
        <div class="checkout-right">
            <div class="checkout-summary">
                <h2 class="checkout-summary-title">Récapitulatif</h2>

                <div class="checkout-summary-items">
                    <?php foreach ($cartItems as $item): ?>
                        <?php $product = $item['product']; ?>
                        <div class="checkout-summary-item">
                            <img src="<?= $baseUrl ?>/public/uploads/<?= htmlspecialchars($product->getImage()) ?>"
                                 alt="<?= htmlspecialchars($product->getName()) ?>">
                            <div class="checkout-summary-item-info">
                                <span class="checkout-item-name"><?= htmlspecialchars($product->getName()) ?></span>
                                <span class="checkout-item-qty">Qté : <?= $item['quantity'] ?></span>
                            </div>
                            <span class="checkout-item-price">
                                <?= number_format($product->getPrice() * $item['quantity'], 2, ',', ' ') ?> €
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="checkout-summary-totals">
                    <div class="checkout-summary-row">
                        <span>Sous-total</span>
                        <span><?= number_format($total, 2, ',', ' ') ?> €</span>
                    </div>
                    <div class="checkout-summary-row">
                        <span>Livraison</span>
                        <span class="checkout-free">Gratuite</span>
                    </div>
                    <div class="checkout-summary-row checkout-summary-total">
                        <span>Total</span>
                        <span><?= number_format($total, 2, ',', ' ') ?> €</span>
                    </div>
                </div>

                <div class="checkout-guarantees">
                    <div class="checkout-guarantee">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Livraison express 24h</span>
                    </div>
                    <div class="checkout-guarantee">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Retours gratuits 30 jours</span>
                    </div>
                    <div class="checkout-guarantee">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Paiement 100% sécurisé</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php else: ?>
        <div class="checkout-empty">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Votre panier est vide.</p>
            <a href="<?= $baseUrl ?>/products" class="checkout-btn-back">Voir les produits</a>
        </div>
    <?php endif; ?>
</div>

<script>
// Formatage automatique numéro de carte
document.getElementById('card_number').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').substring(0, 16);
    this.value = v.replace(/(.{4})/g, '$1 ').trim();
});

// Formatage date expiration
document.getElementById('expiry').addEventListener('input', function () {
    let v = this.value.replace(/\D/g, '').substring(0, 4);
    if (v.length >= 3) v = v.substring(0, 2) + ' / ' + v.substring(2);
    this.value = v;
});

// CVV : chiffres seulement
document.getElementById('cvv').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').substring(0, 3);
});

// Code postal : chiffres seulement
document.getElementById('zip').addEventListener('input', function () {
    this.value = this.value.replace(/\D/g, '').substring(0, 5);
});

// Animation bouton submit
document.getElementById('checkout-form').addEventListener('submit', function (e) {
    const btn = this.querySelector('.checkout-submit');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Traitement en cours…';
    btn.disabled = true;
});
</script>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>
