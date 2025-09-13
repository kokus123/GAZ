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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendeur_id')->constrained('users')->onDelete('cascade');
            $table->string('type_gaz'); // propane, butane, etc.
            $table->integer('quantite_disponible')->default(0);
            $table->integer('quantite_minimum')->default(10); // seuil d'alerte
            $table->decimal('prix_unitaire', 10, 2);
            $table->string('unite'); // kg, litre, etc.
            $table->text('description')->nullable();
            $table->boolean('disponible')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
