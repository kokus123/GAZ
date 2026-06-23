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
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('latitude', 10, 7)->nullable()->after('is_online');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');
            $table->string('quartier')->nullable()->after('longitude');
            $table->string('adresse_detaillee')->nullable()->after('quartier');
            $table->string('telephone')->nullable()->after('adresse_detaillee');
            $table->timestamp('localisation_completee_at')->nullable()->after('telephone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'latitude',
                'longitude',
                'quartier',
                'adresse_detaillee',
                'telephone',
                'localisation_completee_at',
            ]);
        });
    }
};
