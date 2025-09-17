<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow" style="min-width: 350px;">
        <div class="card-body">
            <form id="editForm" action="{{ route('users.update', $user->id) }}" method="POST" onsubmit="return confirmEdit(event)">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold text-primary">Nom :</label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold text-primary">Email :</label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control">
                </div>

                <button type="submit" class="btn btn-success w-100">Modifier</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmEdit(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Confirmation',
            text: "Voulez-vous vraiment modifier cet utilisateur ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, modifier',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                e.target.submit();
            }
        });
    }
</script>
