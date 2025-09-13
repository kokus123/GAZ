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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande_id')->constrained('commandes')->onDelete('cascade');
            $table->string('numero_transaction')->unique();
            $table->decimal('montant', 10, 2);
            $table->enum('methode', ['mobile_money', 'carte_bancaire', 'especes'])->default('mobile_money');
            $table->enum('statut', ['en_attente', 'valide', 'echec', 'rembourse'])->default('en_attente');
            $table->string('numero_telephone')->nullable(); // pour mobile money
            $table->string('operateur')->nullable(); // orange, mtn, moov, etc.
            $table->text('details_transaction')->nullable(); // réponse de l'API
            $table->timestamp('date_validation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
