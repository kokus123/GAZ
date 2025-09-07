<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Visite Gaz</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS (ajoutez le lien selon votre installation) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .custom-card { box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
  </style>
</head>
<body>
  <body class="bg-light">

<!-- Barre de navigation avec bouton Dark/Light -->
<nav class="navbar navbar-light bg-light px-3">
  <span class="navbar-brand">Mon Site</span>
  <button id="themeToggle" class="btn btn-outline-dark ms-auto">🌙 Mode Sombre</button>
</nav>

<div class="container py-5">
  <h1 class="mb-4 text-center">Bienvenue</h1>
  <p class="text-center">Clique sur le bouton pour activer le mode sombre ou clair.</p>
  <div class="card p-3 shadow-sm">
    <p>Exemple de carte pour voir le changement de thème.</p>
  </div>
</div>

<script>
  // On récupère le bouton
  const themeToggle = document.getElementById('themeToggle');

  // Quand on clique dessus
  themeToggle.addEventListener('click', () => {
    document.body.classList.toggle('dark-mode'); // Ajoute/Enlève le mode sombre

    // Change le texte du bouton selon le mode
    if (document.body.classList.contains('dark-mode')) {
      themeToggle.textContent = "☀️ Mode Clair";
      themeToggle.classList.remove("btn-outline-dark");
      themeToggle.classList.add("btn-outline-light");
    } else {
      themeToggle.textContent = "🌙 Mode Sombre";
      themeToggle.classList.remove("btn-outline-light");
      themeToggle.classList.add("btn-outline-dark");
    }
  });
</script>
  <!-- Navbar en haut -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
      <!-- Icône panier à gauche -->
      <a class="navbar-brand d-flex align-items-center" href="#">
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
          <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 6H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 15H4a.5.5 0 0 1-.491-.408L1.01 2H.5a.5.5 0 0 1-.5-.5zm3.14 5l1.25 6.5h7.22l1.25-6.5H3.14z"/>
        </svg>
      </a>
      <!-- Barre de recherche à gauche -->
      <form class="d-flex ms-2" role="search" method="GET" action="#">
        <input class="form-control me-2" type="search" placeholder="Type de gaz..." aria-label="Rechercher" name="search">
        <button class="btn btn-outline-primary" type="submit">Rechercher</button>
      </form>
      <!-- Bouton burger pour mobile -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Menu à droite (vide ou liens à ajouter) -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <!-- Ajoutez des liens ici si besoin -->
        </ul>
      </div>
    </div>
  </nav>

  <!-- Carousel dans une card centrée et large -->
  <div class="container mt-4 mb-4">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10">
        <div class="card custom-card p-3">
          <div id="carouselImages" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2500">
            <div class="carousel-inner">
              <!-- Ajoutez vos images ici -->
              <div class="carousel-item active">
                <img src="station.jpg" class="d-block w-100 rounded" alt="Image 1" style="max-height: 350px; object-fit: cover;">
              </div>
              <div class="carousel-item">
                <img src="camion.jpg" class="d-block w-100 rounded" alt="Image 2" style="max-height: 350px; object-fit: cover;">
              </div>
              <div class="carousel-item">
                <img src="feu.webp" class="d-block w-100 rounded" alt="Image 3" style="max-height: 350px; object-fit: cover;">
              </div>
              <!-- Ajoutez d'autres images si nécessaire -->
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Suivant</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
        <!-- Ajoutez d'autres images si nécessaire -->
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselImages" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Précédent</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselImages" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Suivant</span>
      </button>
    </div>
  </div>

  <!-- Container pour les 3 cards -->
  <div class="container mb-5">
    <div class="row g-4 justify-content-center">
    <!-- ... (vos cards ici, inchangées) ... -->
    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
      <div class="card custom-card p-4 position-relative border-danger card-hover" style="width: 22rem;">
      <!-- <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-primary" style="font-size:1.1rem; left: 18px; top: 18px;">
        13kg
      </span> -->
      <img src="total.webp" class="card-img-top rounded" alt="Gaz">
      <div class="card-body">
        <h5 class="card-title text-center">Total</h5>
        <p class="card-text text-center">Découvrez la performance et la fiabilité de cette catégorie.</p>
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#marqueModal">commander</button>
      </div>
      </div>
    </div>
    <!-- ... (autres cards de la première rangée) ... -->
    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
      <div class="card custom-card p-4 position-relative border-primary card-hover" style="width: 22rem;">
      <!-- <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-primary" style="font-size:1.1rem; left: 18px; top: 18px;">
        35kg
      </span> -->
      <img src="tradex.jpg" class="card-img-top rounded" alt="Gaz">
      <div class="card-body">
        <h5 class="card-title text-center">Tradex</h5>
        <p class="card-text text-center">Description du produit 4 avec détails importants.</p>
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#marqueModal">commander</button>
      </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
      <div class="card custom-card p-4 position-relative border-success card-hover" style="width: 22rem;">
      <!-- <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-primary" style="font-size:1.1rem; left: 18px; top: 18px;">
        75kg
      </span> -->
      <img src="bocom.jpg" class="card-img-top rounded" alt="Gaz">
      <div class="card-body">
        <h5 class="card-title text-center">Bocom</h5>
        <p class="card-text text-center">Description du produit 8 avec détails importants.</p>
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#marqueModal">commander</button>
      </div>
      </div>
    </div>
    </div>
    <!-- Nouvelle rangée de 3 cards -->
    <div class="row g-4 justify-content-center mt-2">
    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
      <div class="card custom-card p-4 position-relative border-warning card-hover" style="width: 22rem;">
      <!-- <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-primary" style="font-size:1.1rem; left: 18px; top: 18px;">
        50kg
      </span> -->
      <img src="sctm.PNG" class="card-img-top rounded" alt="Gaz">
      <div class="card-body">
        <h5 class="card-title text-center">SCTM</h5>
        <p class="card-text text-center">Description du produit 50kg avec détails importants.</p>
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#marqueModal">commander</button>
      </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
      <div class="card custom-card p-4 position-relative card-hover" style="width: 22rem;">
      <!-- <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-primary" style="font-size:1.1rem; left: 18px; top: 18px;">
        90kg
      </span> -->
      <img src="90k.jpg" class="card-img-top rounded" alt="Gaz">
      <div class="card-body">
        <h5 class="card-title text-center">Catégorie 5</h5>
        <p class="card-text text-center">Description du produit 90kg avec détails importants.</p>
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#marqueModal">commander</button>
      </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-4 d-flex justify-content-center">
      <div class="card custom-card p-4 position-relative card-hover" style="width: 22rem;">
      <!-- <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-primary" style="font-size:1.1rem; left: 18px; top: 18px;">
        120kg
      </span> -->
      <img src="120k.jpg" class="card-img-top rounded" alt="Gaz">
      <div class="card-body">
        <h5 class="card-title text-center">Catégorie 6</h5>
        <p class="card-text text-center">Description du produit 120kg avec détails importants.</p>
        <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#marqueModal">commander</button>
      </div>
      </div>
    </div>
    </div>
  </div>
  <style>
    .card-hover {
      transition: transform 0.2s, box-shadow 0.2s;
      cursor: pointer;
    }
    .card-hover:hover {
      transform: translateY(-8px) scale(1.03);
      box-shadow: 0 8px 24px rgba(0,0,0,0.18);
      z-index: 2;
    }
  </style>

  <!-- Modal (structure minimale) -->
  <div class="modal fade" id="marqueModal" tabindex="-1" aria-labelledby="marqueModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="marqueModalLabel">Inspection</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
      Détails de l'inspection ici.
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
    </div>
  </div>

  <!-- Bootstrap JS (ajoutez le lien selon votre installation) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
