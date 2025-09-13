<?php

namespace Database\Seeders;

use App\Models\Commande;
use App\Models\Livraison;
use App\Models\Paiement;
use App\Models\Reçu;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un admin
        $admin = User::create([
            'name' => 'Admin GazApp',
            'email' => 'admin@gazapp.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_online' => true,
        ]);

        // Créer des vendeurs
        $vendeur1 = User::create([
            'name' => 'Vendeur Abidjan',
            'email' => 'vendeur1@gazapp.com',
            'password' => Hash::make('password'),
            'role' => 'vendeur',
            'is_online' => true,
        ]);

        $vendeur2 = User::create([
            'name' => 'Vendeur Yamoussoukro',
            'email' => 'vendeur2@gazapp.com',
            'password' => Hash::make('password'),
            'role' => 'vendeur',
            'is_online' => true,
        ]);

        // Créer des clients
        $client1 = User::create([
            'name' => 'Client Test',
            'email' => 'client@gazapp.com',
            'password' => Hash::make('password'),
            'role' => 'client',
            'is_online' => false,
        ]);

        // Créer des stocks pour les vendeurs
        Stock::create([
            'vendeur_id' => $vendeur1->id,
            'type_gaz' => 'propane',
            'quantite_disponible' => 50,
            'quantite_minimum' => 10,
            'prix_unitaire' => 15000,
            'unite' => 'kg',
            'description' => 'Gaz propane de qualité supérieure',
            'disponible' => true,
        ]);

        Stock::create([
            'vendeur_id' => $vendeur1->id,
            'type_gaz' => 'butane',
            'quantite_disponible' => 30,
            'quantite_minimum' => 5,
            'prix_unitaire' => 12000,
            'unite' => 'kg',
            'description' => 'Gaz butane pour usage domestique',
            'disponible' => true,
        ]);

        Stock::create([
            'vendeur_id' => $vendeur2->id,
            'type_gaz' => 'propane',
            'quantite_disponible' => 40,
            'quantite_minimum' => 8,
            'prix_unitaire' => 14500,
            'unite' => 'kg',
            'description' => 'Gaz propane premium',
            'disponible' => true,
        ]);

        // Créer une commande d'exemple
        $commande = Commande::create([
            'client_id' => $client1->id,
            'vendeur_id' => $vendeur1->id,
            'numero_commande' => 'CMD-'.date('Ymd').'-0001',
            'nom_client' => $client1->name,
            'telephone' => '+225 07 12 34 56 78',
            'email' => $client1->email,
            'quantite' => 2,
            'prix_unitaire' => 15000,
            'prix_total' => 30000,
            'adresse_livraison' => 'Cocody, Abidjan, Côte d\'Ivoire',
            'latitude' => 5.3600,
            'longitude' => -4.0083,
            'statut' => 'en_attente',
            'notes' => 'Livraison urgente demandée',
            'date_livraison_prevue' => now()->addDay(),
        ]);

        // Créer un paiement d'exemple
        $paiement = Paiement::create([
            'commande_id' => $commande->id,
            'numero_transaction' => 'TXN-'.date('YmdHis').'-ABC123',
            'montant' => 30000,
            'methode' => 'mobile_money',
            'statut' => 'valide',
            'numero_telephone' => '+225 07 12 34 56 78',
            'operateur' => 'orange',
            'details_transaction' => json_encode(['transaction_id' => 'MM123456']),
            'date_validation' => now(),
        ]);

        // Créer une livraison d'exemple
        Livraison::create([
            'commande_id' => $commande->id,
            'vendeur_id' => $vendeur1->id,
            'numero_livraison' => 'LIV-'.date('Ymd').'-0001',
            'statut' => 'programmee',
            'adresse_livraison' => $commande->adresse_livraison,
            'latitude' => $commande->latitude,
            'longitude' => $commande->longitude,
            'date_livraison_prevue' => $commande->date_livraison_prevue,
            'nom_livreur' => 'Jean Kouassi',
            'telephone_livreur' => '+225 05 12 34 56 78',
        ]);

        // Créer un reçu d'exemple
        Reçu::create([
            'commande_id' => $commande->id,
            'paiement_id' => $paiement->id,
            'numero_reçu' => 'REC-'.date('Ymd').'-0001',
            'chemin_fichier' => 'receipts/rec-'.date('Ymd').'-0001.pdf',
            'date_generation' => now(),
            'telecharge' => false,
        ]);

        $this->command->info('Données de test créées avec succès !');
        $this->command->info('Admin: admin@gazapp.com / password');
        $this->command->info('Vendeur 1: vendeur1@gazapp.com / password');
        $this->command->info('Vendeur 2: vendeur2@gazapp.com / password');
        $this->command->info('Client: client@gazapp.com / password');
    }
}
