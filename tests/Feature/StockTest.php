<?php

namespace Tests\Feature;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StockTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->vendeur = User::factory()->create(['role' => 'vendeur']);
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->client = User::factory()->create(['role' => 'client']);
    }

    /**
     * Test de création d'un stock par un vendeur
     */
    public function test_vendeur_can_create_stock()
    {
        $this->actingAs($this->vendeur);

        $stockData = [
            'type_gaz' => 'propane',
            'quantite_disponible' => 50,
            'quantite_minimum' => 10,
            'prix_unitaire' => 15000,
            'unite' => 'kg',
            'description' => 'Gaz propane de qualité supérieure',
        ];

        $response = $this->post('/stocks', $stockData);

        $response->assertRedirect();
        $this->assertDatabaseHas('stocks', [
            'vendeur_id' => $this->vendeur->id,
            'type_gaz' => 'propane',
        ]);
    }

    /**
     * Test d'affichage des stocks pour un vendeur
     */
    public function test_vendeur_can_view_own_stocks()
    {
        $this->actingAs($this->vendeur);

        Stock::create([
            'vendeur_id' => $this->vendeur->id,
            'type_gaz' => 'propane',
            'quantite_disponible' => 50,
            'quantite_minimum' => 10,
            'prix_unitaire' => 15000,
            'unite' => 'kg',
            'description' => 'Gaz propane',
            'disponible' => true,
        ]);

        $response = $this->get('/stocks');
        $response->assertStatus(200);
        $response->assertSee('propane');
    }

    /**
     * Test d'affichage des stocks pour un admin
     */
    public function test_admin_can_view_all_stocks()
    {
        $this->actingAs($this->admin);

        Stock::create([
            'vendeur_id' => $this->vendeur->id,
            'type_gaz' => 'propane',
            'quantite_disponible' => 50,
            'quantite_minimum' => 10,
            'prix_unitaire' => 15000,
            'unite' => 'kg',
            'description' => 'Gaz propane',
            'disponible' => true,
        ]);

        $response = $this->get('/stocks');
        $response->assertStatus(200);
        $response->assertSee('propane');
    }

    /**
     * Test de mise à jour d'un stock
     */
    public function test_vendeur_can_update_stock()
    {
        $this->actingAs($this->vendeur);

        $stock = Stock::create([
            'vendeur_id' => $this->vendeur->id,
            'type_gaz' => 'propane',
            'quantite_disponible' => 50,
            'quantite_minimum' => 10,
            'prix_unitaire' => 15000,
            'unite' => 'kg',
            'description' => 'Gaz propane',
            'disponible' => true,
        ]);

        $updateData = [
            'type_gaz' => 'propane',
            'quantite_disponible' => 75,
            'quantite_minimum' => 15,
            'prix_unitaire' => 16000,
            'unite' => 'kg',
            'description' => 'Gaz propane mis à jour',
        ];

        $response = $this->put("/stocks/{$stock->id}", $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('stocks', [
            'id' => $stock->id,
            'quantite_disponible' => 75,
            'prix_unitaire' => 16000,
        ]);
    }

    /**
     * Test de suppression d'un stock
     */
    public function test_vendeur_can_delete_stock()
    {
        $this->actingAs($this->vendeur);

        $stock = Stock::create([
            'vendeur_id' => $this->vendeur->id,
            'type_gaz' => 'propane',
            'quantite_disponible' => 50,
            'quantite_minimum' => 10,
            'prix_unitaire' => 15000,
            'unite' => 'kg',
            'description' => 'Gaz propane',
            'disponible' => true,
        ]);

        $response = $this->delete("/stocks/{$stock->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('stocks', [
            'id' => $stock->id,
        ]);
    }

    /**
     * Test d'accès refusé pour un client
     */
    public function test_client_cannot_access_stocks()
    {
        $this->actingAs($this->client);

        $response = $this->get('/stocks');
        $response->assertStatus(403);
    }

    /**
     * Test de validation des données de stock
     */
    public function test_stock_validation()
    {
        $this->actingAs($this->vendeur);

        $response = $this->post('/stocks', []);

        $response->assertSessionHasErrors([
            'type_gaz',
            'quantite_disponible',
            'quantite_minimum',
            'prix_unitaire',
            'unite',
        ]);
    }

    /**
     * Test de création de stock avec données valides
     */
    public function test_stock_creation_with_valid_data()
    {
        $this->actingAs($this->vendeur);

        $stockData = [
            'type_gaz' => 'butane',
            'quantite_disponible' => 30,
            'quantite_minimum' => 5,
            'prix_unitaire' => 12000,
            'unite' => 'kg',
            'description' => 'Gaz butane pour usage domestique',
        ];

        $response = $this->post('/stocks', $stockData);

        $response->assertRedirect('/stocks');
        $response->assertSessionHas('success', 'Stock créé avec succès !');

        $this->assertDatabaseHas('stocks', [
            'vendeur_id' => $this->vendeur->id,
            'type_gaz' => 'butane',
            'quantite_disponible' => 30,
        ]);
    }

    /**
     * Test d'affichage du formulaire de création
     */
    public function test_stock_create_form_loads()
    {
        $this->actingAs($this->vendeur);

        $response = $this->get('/stocks/create');
        $response->assertStatus(200);
        $response->assertSee('Créer un nouveau stock');
    }
}
