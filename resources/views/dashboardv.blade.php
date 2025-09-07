<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard vendeur - Gaz Express</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8f9fa;
    }
    .sidebar {
      height: 100vh;
      background: #212529;
      color: white;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
      display: block;
      padding: 10px;
      border-radius: 5px;
    }
    .sidebar a:hover {
      background: #495057;
    }
    .content {
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Menu latéral -->
      <nav class="col-md-3 col-lg-2 sidebar">
        <h4 class="text-center">Gaz Express</h4>
        <a href="#">🏠 Tableau de bord</a>
        <a href="#">🛒 Mes commandes</a>
        <a href="#">📦 Produits</a>
        <a href="#">👥 Clients</a>
        <a href="#">🚚 Livraisons</a>
        <a href="#">⚙️ Paramètres</a>
      </nav>

      <!-- Contenu principal -->
      <main class="col-md-9 col-lg-10 content">
        <h2>Bienvenue sur le Dashboard</h2>

        <!-- Statistiques -->
        <div class="row g-4 mb-4">
          <div class="col-md-4">
            <div class="card shadow p-3">
              <h5>Commandes du jour</h5>
              <p><strong>25</strong> commandes</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow p-3">
              <h5>Ventes totales</h5>
              <p><strong>450</strong> bouteilles</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card shadow p-3">
              <h5>Clients actifs</h5>
              <p><strong>120</strong> clients</p>
            </div>
          </div>
        </div>

        <!-- CRUD Utilisateurs -->
        <h3 class="mt-5">👥 Gestion des utilisateurs</h3>
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Formulaire ajout utilisateur -->
        <form action="{{ route('users.store') }}" method="POST" class="mb-4">
          @csrf
          <div class="row g-2">
            <div class="col-md-3">
              <input type="text" name="name" class="form-control" placeholder="Nom" required>
            </div>
            <div class="col-md-3">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-md-3">
              <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            </div>
            <div class="col-md-2">
              <select name="role" class="form-select">
                <option value="client">Client</option>
                <option value="vendeur">Vendeur</option>
              </select>
            </div>
            <div class="col-md-1">
              <button type="submit" class="btn btn-success w-100">+</button>
            </div>
          </div>
        </form>

        <!-- Tableau des utilisateurs -->
        <table class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>ID</th>
              <th>Nom</th>
              <th>Email</th>
              <th>Rôle</th>
              <th>Statut</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
            <tr>
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ ucfirst($user->role) }}</td>
              <td>
                @if($user->is_online)
                  <span class="badge bg-success">En ligne</span>
                @else
                  <span class="badge bg-secondary">Hors ligne</span>
                @endif
              </td>
              <td>
                <!-- Modifier -->
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('PUT')
                  <button class="btn btn-sm btn-primary">Modifier</button>
                </form>
                <!-- Supprimer -->
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-danger">Supprimer</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </main>
    </div>
  </div>
</body>
</html>
