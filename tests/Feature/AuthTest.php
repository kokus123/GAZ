<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test de la page d'accueil
     */
    public function test_home_page_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('GazApp');
    }

    /**
     * Test de la page de connexion
     */
    public function test_login_page_loads()
    {
        $response = $this->get('/connexion');
        $response->assertStatus(200);
        $response->assertSee('Connectez-vous');
    }

    /**
     * Test de la page d'inscription
     */
    public function test_register_page_loads()
    {
        $response = $this->get('/inscription');
        $response->assertStatus(200);
        $response->assertSee('Créer un compte');
    }

    /**
     * Test d'inscription d'un client
     */
    public function test_client_can_register()
    {
        $userData = [
            'name' => 'Test Client',
            'email' => 'client@test.com',
            'password' => 'password123',
            'role' => 'client'
        ];

        $response = $this->post('/inscription', $userData);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'client@test.com',
            'role' => 'client'
        ]);
    }

    /**
     * Test d'inscription d'un vendeur
     */
    public function test_vendeur_can_register()
    {
        $userData = [
            'name' => 'Test Vendeur',
            'email' => 'vendeur@test.com',
            'password' => 'password123',
            'role' => 'vendeur'
        ];

        $response = $this->post('/inscription', $userData);
        
        $response->assertRedirect();
        $this->assertDatabaseHas('users', [
            'email' => 'vendeur@test.com',
            'role' => 'vendeur'
        ]);
    }

    /**
     * Test de connexion
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        $response = $this->post('/connexion', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        $response->assertRedirect();
        $this->assertAuthenticated();
    }

    /**
     * Test de déconnexion
     */
    public function test_user_can_logout()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);
        
        $response = $this->post('/logout');
        
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    /**
     * Test de redirection selon le rôle après connexion
     */
    public function test_client_redirected_to_client_dashboard()
    {
        $user = User::factory()->create(['role' => 'client']);

        $response = $this->actingAs($user)->get('/dashboardc');
        $response->assertStatus(200);
        $response->assertSee('Mon Dashboard');
    }

    /**
     * Test de redirection selon le rôle après connexion
     */
    public function test_vendeur_redirected_to_vendeur_dashboard()
    {
        $user = User::factory()->create(['role' => 'vendeur']);

        $response = $this->actingAs($user)->get('/dashboardv');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Vendeur');
    }

    /**
     * Test de redirection selon le rôle après connexion
     */
    public function test_admin_redirected_to_admin_dashboard()
    {
        $user = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Administrateur');
    }
}