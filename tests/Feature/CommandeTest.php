<?php

namespace Tests\Feature;

use App\Models\Commande;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommandeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Créer des utilisateurs de test
        $this->client = User::factory()->create(['role' => 'client']);
        $this->vendeur = User::factory()->create(['role' => 'vendeur']);
        $this->admin = User::factory()->create(['role' => 'admin']);

        // Créer un stock pour le vendeur
        $this->stock = Stock::create([
            'vendeur_id' => $this->vendeur->id,
            'type_gaz' => 'propane',
            'quantite_disponible' => 50,
            'quantite_minimum' => 10,
            'prix_unitaire' => 15000,
            'unite' => 'kg',
            'description' => 'Gaz propane de qualité',
            'disponible' => true,
        ]);
    }

    /**
     * Test de création d'une commande par un client
     */
    public function test_client_can_create_commande()
    {
        $this->actingAs($this->client);

        $commandeData = [
            'nom_client' => 'Test Client',
            'telephone' => '+225 07 12 34 56 78',
            'email' => 'client@test.com',
            'quantite' => 2,
            'adresse_livraison' => 'Cocody, Abidjan',
            'latitude' => 5.3600,
            'longitude' => -4.0083,
            'type_gaz' => 'propane',
            'notes' => 'Livraison urgente',
        ];

        $response = $this->post('/commandes', $commandeData);

        $response->assertRedirect();
        $this->assertDatabaseHas('commandes', [
            'nom_client' => 'Test Client',
            'client_id' => $this->client->id,
        ]);
    }

    /**
     * Test d'affichage des commandes pour un client
     */
    public function test_client_can_view_own_commandes()
    {
        $this->actingAs($this->client);

        // Créer une commande pour ce client
        Commande::create([
            'client_id' => $this->client->id,
            'vendeur_id' => $this->vendeur->id,
            'numero_commande' => 'CMD-TEST-001',
            'nom_client' => 'Test Client',
            'telephone' => '+225 07 12 34 56 78',
            'quantite' => 2,
            'prix_unitaire' => 15000,
            'prix_total' => 30000,
            'adresse_livraison' => 'Cocody, Abidjan',
            'latitude' => 5.3600,
            'longitude' => -4.0083,
            'statut' => 'en_attente',
        ]);

        $response = $this->get('/commandes');
        $response->assertStatus(200);
        $response->assertSee('CMD-TEST-001');
    }

    /**
     * Test d'affichage des commandes pour un vendeur
     */
    public function test_vendeur_can_view_own_commandes()
    {
        $this->actingAs($this->vendeur);

        // Créer une commande pour ce vendeur
        Commande::create([
            'client_id' => $this->client->id,
            'vendeur_id' => $this->vendeur->id,
            'numero_commande' => 'CMD-TEST-002',
            'nom_client' => 'Test Client',
            'telephone' => '+225 07 12 34 56 78',
            'quantite' => 2,
            'prix_unitaire' => 15000,
            'prix_total' => 30000,
            'adresse_livraison' => 'Cocody, Abidjan',
            'latitude' => 5.3600,
            'longitude' => -4.0083,
            'statut' => 'en_attente',
        ]);

        $response = $this->get('/commandes');
        $response->assertStatus(200);
        $response->assertSee('CMD-TEST-002');
    }

    /**
     * Test de confirmation d'une commande par un vendeur
     */
    public function test_vendeur_can_confirm_commande()
    {
        $this->actingAs($this->vendeur);

        $commande = Commande::create([
            'client_id' => $this->client->id,
            'vendeur_id' => $this->vendeur->id,
            'numero_commande' => 'CMD-TEST-003',
            'nom_client' => 'Test Client',
            'telephone' => '+225 07 12 34 56 78',
            'quantite' => 2,
            'prix_unitaire' => 15000,
            'prix_total' => 30000,
            'adresse_livraison' => 'Cocody, Abidjan',
            'latitude' => 5.3600,
            'longitude' => -4.0083,
            'statut' => 'en_attente',
        ]);

        $response = $this->post("/commandes/{$commande->id}/confirmer");

        $response->assertRedirect();
        $this->assertDatabaseHas('commandes', [
            'id' => $commande->id,
            'statut' => 'confirmee',
        ]);
    }

    /**
     * Test d'annulation d'une commande par un client
     */
    public function test_client_can_cancel_commande()
    {
        $this->actingAs($this->client);

        $commande = Commande::create([
            'client_id' => $this->client->id,
            'vendeur_id' => $this->vendeur->id,
            'numero_commande' => 'CMD-TEST-004',
            'nom_client' => 'Test Client',
            'telephone' => '+225 07 12 34 56 78',
            'quantite' => 2,
            'prix_unitaire' => 15000,
            'prix_total' => 30000,
            'adresse_livraison' => 'Cocody, Abidjan',
            'latitude' => 5.3600,
            'longitude' => -4.0083,
            'statut' => 'en_attente',
        ]);

        $response = $this->post("/commandes/{$commande->id}/annuler");

        $response->assertRedirect();
        $this->assertDatabaseHas('commandes', [
            'id' => $commande->id,
            'statut' => 'annulee',
        ]);
    }

    /**
     * Test d'affichage d'une commande spécifique
     */
    public function test_user_can_view_commande_details()
    {
        $this->actingAs($this->client);

        $commande = Commande::create([
            'client_id' => $this->client->id,
            'vendeur_id' => $this->vendeur->id,
            'numero_commande' => 'CMD-TEST-005',
            'nom_client' => 'Test Client',
            'telephone' => '+225 07 12 34 56 78',
            'quantite' => 2,
            'prix_unitaire' => 15000,
            'prix_total' => 30000,
            'adresse_livraison' => 'Cocody, Abidjan',
            'latitude' => 5.3600,
            'longitude' => -4.0083,
            'statut' => 'en_attente',
        ]);

        $response = $this->get("/commandes/{$commande->id}");
        $response->assertStatus(200);
        $response->assertSee('CMD-TEST-005');
    }

    /**
     * Test de validation des données de commande
     */
    public function test_commande_validation()
    {
        $this->actingAs($this->client);

        $response = $this->post('/commandes', []);

        $response->assertSessionHasErrors([
            'nom_client',
            'telephone',
            'quantite',
            'adresse_livraison',
            'latitude',
            'longitude',
            'type_gaz',
        ]);
    }

    /**
     * Test de redirection vers le formulaire de commande
     */
    public function test_commande_create_page_loads()
    {
        $this->actingAs($this->client);

        $response = $this->get('/commandes/create');
        $response->assertStatus(200);
        $response->assertSee('Nouvelle Commande');
    }
}
