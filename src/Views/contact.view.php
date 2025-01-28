<?php

require_once(__DIR__ . "/partials/head.php");

?>

<div class="contact">
    <img src="public/img/contact.png" alt="">
    <h1>Contactez-nous</h1>
</div>


<form action="/contact" method="post">
    <label for="name">Prénom :</label>
    <input type="text" id="name" name="name" required>

    <label for="last name">Nom de famille :</label>
    <input type="text" id="last name" name="last name" required>

    <label for="email">Email :</label>
    <input type="email" id="email" name="email" required>

    <label for="message">Message :</label>
    <textarea id="message" name="message" rows="5" required></textarea>

    <button type="submit">Envoyer</button>
</form>

<?php

require_once(__DIR__ . "/partials/footer.php");

?>