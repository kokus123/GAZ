<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Plateforme Gaz</title>
  <!-- Lien Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      padding-top: 70px; /* espace pour la navbar fixe */
    }
    /* Card principale en haut */
    .hero-card {
      width: 100%;
      border: none;
      border-radius: 0;
      overflow: hidden;
    }
    .hero-card video {
      width: 200px;
      height: auto;
      margin: 10px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    /* Cards en bas */
    .custom-card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .custom-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">GAZ EXPRESS</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
              aria-controls="navbarNav" aria-expanded="false" aria-label="Menu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Produits</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Grande card vidéos -->
  <div class="card hero-card shadow-lg p-4 mb-5 bg-white">
    <div class="card-body d-flex justify-content-center flex-wrap">
      <video autoplay muted loop>
        <source src="video1.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
      </video>
      <video autoplay muted loop>
        <source src="video2.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
      </video>
      <video autoplay muted loop>
        <source src="video3.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
      </video>
      <video autoplay muted loop>
        <source src="video4.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
      </video>
    </div>
  </div>

  <!-- Container pour les 8 cards -->
  <div class="container mb-5">
    <div class="row g-4">
      <!-- 8 cards -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz1.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 1</h5>
            <p class="card-text">Description du produit 1 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz2.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 2</h5>
            <p class="card-text">Description du produit 2 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz3.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 3</h5>
            <p class="card-text">Description du produit 3 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz4.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 4</h5>
            <p class="card-text">Description du produit 4 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>

      <!-- Ligne 2 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz5.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 5</h5>
            <p class="card-text">Description du produit 5 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz6.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 6</h5>
            <p class="card-text">Description du produit 6 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz7.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 7</h5>
            <p class="card-text">Description du produit 7 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>

      <div class="col-12 col-md-6 col-lg-3">
        <div class="card custom-card p-3">
          <img src="gaz8.jpg" class="card-img-top rounded" alt="Gaz">
          <div class="card-body">
            <h5 class="card-title">Produit 8</h5>
            <p class="card-text">Description du produit 8 avec détails importants.</p>
            <a href="#" class="btn btn-primary w-100">Commander</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
