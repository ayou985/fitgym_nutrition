<?php require_once(__DIR__ . "/partials/head.php"); ?>

<?php if (!empty($_SESSION['flash'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: '<?= $_SESSION["flash"]["type"] ?>',
            title: '<?= $_SESSION["flash"]["type"] === "success" ? "Succès" : "Oups !" ?>',
            text: '<?= $_SESSION["flash"]["message"] ?>',
            confirmButtonColor: '#d33'
        });
    </script>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<div class="contact">
    <img src="/public/img/contact.png" alt="">
    <h1>Contactez-nous</h1>
</div>
<div class="contact-form-wrapper">
    <form action="/contact" method="post">
        <!-- Anti-spam : champ invisible (honeypot) -->
        <input type="text" name="honeypot" style="display:none">

        <!-- Anti-spam : délai de soumission -->
        <input type="hidden" name="form_token" value="<?= time(); ?>">

        <label for="name">Prénom : (facultatif)</label>
        <input type="text" id="name" name="name" >

        <label for="last_name">Nom de famille :(facultatif)</label>
        <input type="text" id="last_name" name="last_name" >

        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required>

        <label for="message">Message :</label>
        <textarea id="message" name="message" rows="5" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</div>

<?php require_once(__DIR__ . "/partials/footer.php"); ?>