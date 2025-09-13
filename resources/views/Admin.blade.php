<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                <form action="{{ route('Admin.users.update', $user->id) }}" method="POST" class="d-inline">
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