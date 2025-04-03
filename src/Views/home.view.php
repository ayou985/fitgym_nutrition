<?php

require_once(__DIR__ . "/partials/head.php");

?>

<div class="carousel-container">
    <div id="carouselExample" class="carousel slide">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="public/img/carrousel1.png"  class="w-100" alt="slide 1">
            </div>
            <div class="carousel-item">
                <img src="/public/img/carrousel2.png" class="w-100" alt="slide 2">
            </div>
            <div class="carousel-item">
                <img src="public/img/carrousel3.jpg" class="w-100" alt="slide 3">
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

<section>
    <div class="home-text">
        <p>Les produits recommandés</p>
    </div>

    <div class="home-recommended-image">
        <img src="public/img/img-acc.png" alt="produit recommandé">
        <img src="public/img/produit_gainer.png" alt="produit recommandé">
        <img src="public/img/bcaa.png" alt="produit recommandé">
        <img src="public/img/produit-accueil.png" alt="produit recommandé">
        <img src="public/img/barre-proteine.png" alt="produit recommandé">
    </div>
</section>

<div class="home-header2">
    <img src="/public/img/accueil.png" alt="deuxième image ">
</div>

<section>
    <div class="home-text2">
        <p>Découvrer les packs</p>
    </div>

    <div class="home-pack">
        <img src="public/img/pack6.png" alt="découvrir les packs">
        <img src="public/img/pack7.png" alt="découvrir les packs">
        <img src="public/img/pack4.png" alt="découvrir les packs">
        <img src="public/img/pack5.png" alt="découvrir les packs">
        <img src="public/img/pack8.png" alt="découvrir les packs">
    </div>

</section>

<?php

require_once(__DIR__ . "/partials/footer.php");

?>