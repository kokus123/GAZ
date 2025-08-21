<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gaz Express - Dashboard</title>
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
        <p>Ici, tu vois les statistiques principales :</p>

        <div class="row g-4">
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

        <hr>

        <h4>Commandes récentes</h4>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Client</th>
              <th>Produit</th>
              <th>Statut</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Jean Dupont</td>
              <td>Bouteille Total 12kg</td>
              <td><span class="badge bg-success">Livrée</span></td>
              <td>21/08/2025</td>
            </tr>
            <tr>
              <td>Amina Diallo</td>
              <td>Bouteille Camgaz 6kg</td>
              <td><span class="badge bg-warning">En livraison</span></td>
              <td>21/08/2025</td>
            </tr>
          </tbody>
        </table>
      </main>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
