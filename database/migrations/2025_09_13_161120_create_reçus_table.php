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
        Schema::create('reçus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->foreignId('paiement_id')->constrained('paiements')->onDelete('cascade');
            $table->string('numero_reçu')->unique();
            $table->string('chemin_fichier'); // chemin vers le PDF
            $table->timestamp('date_generation');
            $table->boolean('telecharge')->default(false);
            $table->timestamp('date_telechargement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reçus');
    }
};
