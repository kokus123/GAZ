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
        Schema::create('livraisons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('vendeur_id')->constrained('users')->onDelete('cascade');
            $table->string('numero_livraison')->unique();
            $table->enum('statut', ['programmee', 'en_cours', 'livree', 'echec'])->default('programmee');
            $table->text('adresse_livraison');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('date_livraison_prevue');
            $table->timestamp('date_livraison_effective')->nullable();
            $table->text('notes_livraison')->nullable();
            $table->string('nom_livreur')->nullable();
            $table->string('telephone_livreur')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('livraisons');
    }
};
