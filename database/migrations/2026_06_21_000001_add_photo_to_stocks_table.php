<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            if (! Schema::hasColumn('stocks', 'photo')) {
                $table->string('photo')->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            if (Schema::hasColumn('stocks', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
};
