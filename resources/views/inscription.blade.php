<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
  <div class="card shadow-lg border-0" style="max-width: 450px; width: 100%;">
    <div class="card-body p-4">
      <h3 class="card-title text-center mb-4 fw-bold text-success">
        <i class="bi bi-person-plus-fill"></i> Inscription
      </h3>

      <form action="{{ route('inscription.store') }}" method="POST">
        @csrf

        <div class="mb-3">
          <label class="form-label">Nom</label>
          <input type="text" name="name" class="form-control" placeholder="Entrez votre nom" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="Entrez votre email" required>
        </div>

        <div class="mb-3">
          <label class="form-label">Rôle</label>
          <select name="role" class="form-select" required>
            <!-- <option value="">-- Sélectionner --</option> -->
            <option value="client">Client</option>
            <option value="vendeur">Vendeur</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">Mot de passe</label>
          <input type="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success">Créer un compte</button>
        </div>
      </form>

      <hr>

      <div class="text-center">
        <p><a href="{{ route('connexion') }}" class="text-decoration-black">Vous avez déjà un compte ? Connectez-vous</a></p>
        <p><a href="{{ route('welcome') }}" class="text-decoration-none">Retour au catalogue</a></p>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</body>
</html>
