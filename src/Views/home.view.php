<?php

require_once(__DIR__ . "/partials/head.php");

?>

<div class="carousel-container">
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="public/img/carrousel1.png" class="d-block w-100" alt="slide 1">
            </div>
            <div class="carousel-item">
                <img src="/public/img/carrousel2.png" class="d-block w-100" alt="slide 2">
            </div>
            <div class="carousel-item">
                <img src="public/img/carrousel3.jpg" class="d-block w-100" alt="slide 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

<div class="home-text">
    <p>Les produits recommandé</p>
</div>

<div class="recommended-image">
    <img src="public/img/produit_whey.png" alt="produit recommandé">
    <img src="public/img/produit_gainer.png" alt="produit recommandé">
    <img src="public/img/bcaa.png" alt="produit recommandé">
</div>


<?php

require_once(__DIR__ . "/partials/footer.php");

?>