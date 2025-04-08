<?php require_once(__DIR__ . "/partials/head.php"); ?>

<div class="container">
    <form method="POST" class="register-form">

        <h1>Inscription</h1>
        <p>Veuillez remplir les champs indiqués ci-dessous afin de créer votre compte.</p>

        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="lastName" required
            value="<?= isset($_POST['lastName']) ? htmlspecialchars($_POST['lastName']) : '' ?>">

        <label for="prenom">Prénom :</label>
        <input type="text" id="prenom" name="firstName" required
            value="<?= isset($_POST['firstName']) ? htmlspecialchars($_POST['firstName']) : '' ?>">

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required
            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">


        <label for="password">Mot de passe :</label>
        <div style="position: relative;">
            <input type="password" id="password" name="password" required style="padding-right: 30px;">
            <span onclick="togglePassword()" style="position: absolute; right: 10px; top: 8px; cursor: pointer;">👁️</span>
        </div>
        <label for="confirm-password">Confirmer le mot de passe :</label>
        <div style="position: relative;">
            <input type="password" id="confirm-password" name="confirm_password" required style="padding-right: 30px;">
            <span onclick="toggleConfirmPassword()" style="position: absolute; right: 10px; top: 8px; cursor: pointer;">👁️</span>
        </div>

        <?php if (!empty($this->arrayError['password'])): ?>
            <p style="color: red; font-weight: bold;">
                <?= $this->arrayError['password'] ?>
            </p>
        <?php endif; ?>


        <button type="submit">S'inscrire</button>

    </form>
</div>

<script>
    function togglePassword() {
        const pwd = document.getElementById("password");
        pwd.type = pwd.type === "password" ? "text" : "password";
    }

    function toggleConfirmPassword() {
        const confirmPwd = document.getElementById("confirm-password");
        confirmPwd.type = confirmPwd.type === "password" ? "text" : "password";
    }

    document.querySelector("form").addEventListener("submit", function(e) {
        const pwd = document.getElementById("password").value;
        const confirm = document.getElementById("confirm-password").value;

        if (pwd !== confirm) {
            e.preventDefault();
            alert("❌ Les mots de passe ne correspondent pas !");
        }
    });
</script>



<?php require_once(__DIR__ . "/partials/footer.php"); ?>