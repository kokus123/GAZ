<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <!-- Carte -->
            <div class="card shadow-lg mt-5 rounded-4">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold text-primary mb-4">
                        <marquee behavior="scroll" direction="right">Mot de passe oublié</marquee>
                    </h4>

                    <form action="Mot-de-passe" method="POST">
                        @csrf
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse e-mail</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Entrez votre e-mail" required>
                        </div>

                        <!-- Bouton -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Envoyer le lien
                            </button>
                        </div>
                    </form>

                    <!-- Lien inscription -->
                    <div class="text-end mt-3">
                        <a href="/connexion" class="text-decoration-none">
                            Vous avez déjà un compte ? Connectez-vous
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
