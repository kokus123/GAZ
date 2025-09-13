@extends('layouts.app')

@section('title', 'Géolocalisation')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Géolocalisation</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Obtenir votre position</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-4">
                        Cliquez sur le bouton ci-dessous pour obtenir votre position actuelle.
                        Cette information sera utilisée pour vous rediriger vers le vendeur le plus proche.
                    </p>
                    
                    <button id="getLocation" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        📍 Obtenir ma position
                    </button>
                    
                    <div id="locationResult" class="mt-4 hidden">
                        <div class="bg-green-50 p-3 rounded-lg">
                            <p class="text-sm text-green-800">
                                <strong>Position obtenue :</strong>
                            </p>
                            <p class="text-sm text-green-700" id="locationText"></p>
                        </div>
                    </div>
                    
                    <div id="locationError" class="mt-4 hidden">
                        <div class="bg-red-50 p-3 rounded-lg">
                            <p class="text-sm text-red-800">
                                <strong>Erreur :</strong>
                            </p>
                            <p class="text-sm text-red-700" id="errorText"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-gray-800">Vendeurs à proximité</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 mb-4">
                        Une fois votre position obtenue, nous pourrons vous montrer les vendeurs les plus proches.
                    </p>
                    
                    <div id="vendorsList" class="hidden">
                        <h4 class="font-semibold text-gray-800 mb-2">Vendeurs disponibles :</h4>
                        <div id="vendorsContent" class="space-y-2">
                            <!-- Les vendeurs seront affichés ici -->
                        </div>
                    </div>
                    
                    <div id="noVendors" class="hidden">
                        <div class="bg-yellow-50 p-3 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                Aucun vendeur disponible dans votre zone pour le moment.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Carte interactive</h3>
            <div class="bg-gray-100 p-4 rounded-lg">
                <div id="map" style="height: 400px; width: 100%;" class="rounded-lg">
                    <!-- La carte sera affichée ici -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('getLocation').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                
                document.getElementById('locationText').textContent = 
                    `Latitude: ${latitude.toFixed(6)}, Longitude: ${longitude.toFixed(6)}`;
                document.getElementById('locationResult').classList.remove('hidden');
                document.getElementById('locationError').classList.add('hidden');
                
                // Simuler la recherche de vendeurs
                simulateVendorSearch(latitude, longitude);
            },
            function(error) {
                let errorMessage = 'Erreur inconnue';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Accès à la localisation refusé par l\'utilisateur';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'Position indisponible';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Délai d\'attente dépassé';
                        break;
                }
                
                document.getElementById('errorText').textContent = errorMessage;
                document.getElementById('locationError').classList.remove('hidden');
                document.getElementById('locationResult').classList.add('hidden');
            }
        );
    } else {
        document.getElementById('errorText').textContent = 'Géolocalisation non supportée par ce navigateur';
        document.getElementById('locationError').classList.remove('hidden');
    }
});

function simulateVendorSearch(lat, lng) {
    // Simuler des vendeurs à proximité
    const vendors = [
        { name: 'Station Total', distance: '0.5 km', available: true },
        { name: 'Station Primagaz', distance: '1.2 km', available: true },
        { name: 'Station Shell', distance: '2.1 km', available: false }
    ];
    
    const vendorsContent = document.getElementById('vendorsContent');
    vendorsContent.innerHTML = '';
    
    vendors.forEach(vendor => {
        const vendorDiv = document.createElement('div');
        vendorDiv.className = `p-3 rounded-lg ${vendor.available ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'}`;
        vendorDiv.innerHTML = `
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800">${vendor.name}</p>
                    <p class="text-sm text-gray-600">Distance: ${vendor.distance}</p>
                </div>
                <div>
                    <span class="px-2 py-1 text-xs rounded-full ${vendor.available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${vendor.available ? 'Disponible' : 'Indisponible'}
                    </span>
                </div>
            </div>
        `;
        vendorsContent.appendChild(vendorDiv);
    });
    
    document.getElementById('vendorsList').classList.remove('hidden');
}
</script>
@endsection