<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('vendeur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('numero_commande')->unique();
            $table->string('nom_client');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->integer('quantite');
            $table->decimal('prix_unitaire', 10, 2);
            $table->decimal('prix_total', 10, 2);
            $table->text('adresse_livraison');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('statut', ['en_attente', 'confirmee', 'en_cours', 'livree', 'annulee'])->default('en_attente');
            $table->text('notes')->nullable();
            $table->timestamp('date_livraison_prevue')->nullable();
            $table->timestamp('date_livraison_effective')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
