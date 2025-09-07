<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Page d'accueil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Animations -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        .navbar {
            background: linear-gradient(to orange);
        }
        .navbar .nav-link {
            color: rgb(184, 137, 10) !important;
            font-weight: bold;
        }
        .navbar .nav-link:hover {
            color: black !important;
        }
        header {
            background: url('https://images.unsplash.com/photo-1581093448790-ffea0f68b8a2') center/cover no-repeat;
            color: rgba(238, 242, 243, 0.945);
            height: 80vh;
            display: flex;
            align-items: center;
            text-align: center;
            position: relative;
        }
        header::before {
            content: "";
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        header .content {
            position: relative;
            z-index: 1;
        }
        
        .feature-box {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: 0.3s;
        }
        .feature-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        footer {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-dark fw-bold" href="#"><i class="bi bi-fire"></i> GAZ EXPRESS</a>
        <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link btn btn-outline-warning" href="/connexion">Se connecter</a></li>
                <li class="nav-item"><a class="btn btn-outline-warning grap-5 nav-link"href="/inscription">S'inscrire</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Section de titre -->
<header>
    <div class="container content animate_animated animate_fadeInDown">
        <h1 class="display-4 fw-bold">Bienvenue sur GAZ EXPRESS</h1>
        <p class="lead">Commandez facilement vos bouteilles de gaz où que vous soyez</p>
    </div>
</header>

<!-- Avantages de la plateforme -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="mb-5 animate_animated animate_fadeIn">Pourquoi Notre Plateforme?</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-box animate_animated animate_zoomIn">
                    <i class="bi bi-lightning-charge text-success display-4"></i>
                    <h4 class="mt-3" style="color: green;">Rapidité</h4>
                    <p>Commandez votre gaz en quelques clics et recevez-le rapidement chez vous.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box animate_animated animate_zoomIn" style="animation-delay:0.2s;">
                    <i class="bi bi-shield-lock-fill text-warning display-4"></i>
                    <h4 class="mt-3" style="color: yellow;">Sécurité</h4>
                    <p>Vos informations et vos transactions sont protégées, pour une tranquillité d’esprit totale</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="feature-box animate_animated animate_zoomIn" style="animation-delay:0.4s;">
                    <i class="bi bi-graph-up text-danger display-4"></i>
                    <h4 class="mt-3" style="color: red;">Efficacité</h4>
                    <p>Suivez vos commandes et gérez vos achats de gaz facilement et sans effort.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pied de page -->
<footer>
    &copy; <?php echo date("Y"); ?> Gaz express - Tous droits réservés
</footer>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>