<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Client - Gaz Express</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="#">Gaz Express - Client</a>
    </div>
  </nav>

  <div class="container my-4">
    <h2 class="mb-4 text-center">Bienvenue sur votre espace client</h2>

    <!-- Bouton commander -->
    <div class="mb-4 text-center">
      <button class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#commandeModal">🛒 Commander une bouteille</button>
    </div>

    <!-- Commandes en cours -->
    <h4>📦 Commandes en cours</h4>
    <div class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Commande 101</h5>
            <p>Produit : Bouteille Total 12kg</p>
            <p>Statut : <span class="badge bg-warning text-dark">En livraison</span></p>
            <p>Adresse : Yaoundé, Quartier Tsinga</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Commande 102</h5>
            <p>Produit : Bouteille Camgaz 6kg</p>
            <p>Statut : <span class="badge bg-success">Livrée</span></p>
            <p>Adresse : Douala, Bonapriso</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Commande 103</h5>
            <p>Produit : Bouteille Bocom 6kg</p>
            <p>Statut : <span class="badge bg-success">Livrée</span></p>
            <p>Adresse : Yaoundé, Essos</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Historique des commandes -->
    <h4>📄 Historique des commandes</h4>
    <table class="table table-striped table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Produit</th>
          <th>Statut</th>
          <th>Date</th>
          <th>Reçu</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>100</td>
          <td>Bouteille Total 6kg</td>
          <td><span class="badge bg-success">Livrée</span></td>
          <td>20/08/2025</td>
          <td><a href="#" class="btn btn-sm btn-primary">Télécharger</a></td>
        </tr>
        <tr>
          <td>99</td>
          <td>Bouteille Camgaz 12kg</td>
          <td><span class="badge bg-success">Livrée</span></td>
          <td>19/08/2025</td>
          <td><a href="#" class="btn btn-sm btn-primary">Télécharger</a></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Modal de Commande -->
  <div class="modal fade"
