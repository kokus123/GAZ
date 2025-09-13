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
        Schema::create('signalements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->nullable()->constrained('commandes')->onDelete('set null');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['non_livraison', 'incendie', 'autre'])->default('non_livraison');
            $table->enum('service', ['police', 'pompiers', 'gendarmerie'])->default('police');
            $table->text('description');
            $table->text('adresse_incident');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('statut', ['en_attente', 'traite', 'resolu'])->default('en_attente');
            $table->string('numero_signalement')->unique();
            $table->text('reponse_service')->nullable();
            $table->timestamp('date_traitement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signalements');
    }
};
