@extends('layouts.app')

@section('title', 'Nouvelle Commande')

@section('content')

<div class="container mx-auto px-4 py-8">

<div class="bg-white rounded-xl shadow-lg p-6">

    <!-- 🔵 PROGRESSION -->
    <div class="mb-6">
        <div class="flex justify-between text-xs text-gray-500 mb-2">
            <span>Client</span>
            <span>Gaz</span>
            <span>Livraison</span>
            <span>Finalisation</span>
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2">
            <div id="progress-bar"
                 class="bg-green-500 h-2 rounded-full transition-all duration-300"
                 style="width: 0%"></div>
        </div>

        <p id="progress-text" class="text-sm text-gray-600 mt-2">
            0% complété
        </p>
    </div>

    <!-- FORM -->
    <form action="{{ route('commandes.store') }}" method="POST">
        @csrf

        <!-- CLIENT -->
        <div class="mb-5">
            <label class="font-semibold">Nom complet</label>
            <input type="text" name="nom_client" class="input" oninput="updateProgress()" required>
        </div>

        <div class="mb-5">
            <label class="font-semibold">Téléphone</label>
            <input type="tel" name="telephone" class="input" oninput="updateProgress()" required>
        </div>

        <div class="mb-5">
            <label>Email</label>
            <input type="email" name="email" class="input" oninput="updateProgress()">
        </div>

        <!-- GAZ -->
        <div class="mb-5">
            <label>Type de gaz</label>
            <select name="type_gaz" class="input" onchange="updateProgress()" required>
                <option value="">Choisir</option>
                <option value="propane">Propane</option>
                <option value="butane">Butane</option>
            </select>
        </div>

        <div class="mb-5">
            <label>Quantité</label>
            <input type="number" name="quantite" class="input" oninput="updateProgress()" required>
        </div>

        <div class="mb-5">
            <label>Prix unitaire</label>
            <input type="number" name="prix_unitaire" class="input" value="15000" oninput="updateProgress()" required>
        </div>

        <!-- LIVRAISON -->
        <div class="mb-5">
            <label>Adresse de livraison</label>
            <textarea name="adresse_livraison" class="input" oninput="updateProgress()" required></textarea>
        </div>

        <div class="mb-5">
            <label>Latitude</label>
            <input type="text" name="latitude" class="input" oninput="updateProgress()">
        </div>

        <div class="mb-5">
            <label>Longitude</label>
            <input type="text" name="longitude" class="input" oninput="updateProgress()">
        </div>

        <!-- NOTES -->
        <div class="mb-5">
            <label>Notes</label>
            <textarea name="notes" class="input" oninput="updateProgress()"></textarea>
        </div>

        <!-- SUBMIT -->
        <button type="submit"
                class="bg-green-600 text-white px-6 py-3 rounded-lg w-full mt-4">
            📦 Valider la commande
        </button>

    </form>
</div>
</div>

<!-- STYLE -->
<style>
.input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-top: 5px;
}
</style>

<!-- JS PRO -->
<script>
function updateProgress() {

    let fields = document.querySelectorAll('input, select, textarea');
    let filled = 0;
    let total = 0;

    fields.forEach(f => {

        if (f.type !== "submit") {
            total++;

            if (f.value.trim() !== "") {
                filled++;
            }
        }
    });

    let percent = Math.round((filled / total) * 100);

    document.getElementById('progress-bar').style.width = percent + "%";
    document.getElementById('progress-text').innerText = percent + "% complété";
}
</script>

@endsection