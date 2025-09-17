<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs</title>

    <!-- ✅ Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- ✅ Icônes Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
<div class="container">

    <!-- ✅ Titre en dehors du tableau -->
    <h2 class="text-center mb-4 fw-bold text-dark">📋 Liste des utilisateurs</h2>

    <!-- ✅ Card centrée -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <!-- ✅ Tableau des utilisateurs -->
            <table class="table table-striped table-hover align-middle text-center">
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
                              <a href="{{ route('users.edit', $user->id) }}" 
                                      class="btn btn-sm btn-primary"
                                     onclick="return confirm('Voulez-vous vraiment modifier cet utilisateur ?');">
                                     <i class="bi bi-pencil-square"></i> Modifier
                              </a>

                            <!-- Supprimer -->
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>
</body>
</html>
