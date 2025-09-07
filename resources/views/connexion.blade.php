<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/v4-shims.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
  <div class="card shadow-lg border-0" style="max-width: 420px; width: 100%;">
    <div class="card-body p-4">
      <h3 class="card-title text-center mb-4 fw-bold text-primary">
        <i class="bi bi-lock-fill"></i> Connexion
      </h3>
      <div class="d-flex justify-content-center gap-3 mb-3">
        <i class="bi bi-facebook text-primary fs-1"></i>
        <i class="bi bi-google text-danger fs-1"></i>
      </div>

      <form action="{{ route('connexion.login') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Entrez votre email" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
      </form>

      <hr>

      <div class="text-center">
        <p class="mb-1"><a href="{{ route('inscription.form') }}" class="text-decoration-none">Créer un compte</a></p>
        <p class="mb-1"><a href="{{ route('forgot') }}" class="text-decoration-none">Mot de passe oublié ?</a></p>
        <p><a href="{{ route('welcome') }}" class="text-decoration-none">Retour au catalogue</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icons (pour l’icône de cadenas) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
