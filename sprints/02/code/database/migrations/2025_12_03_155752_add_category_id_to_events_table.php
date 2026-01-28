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
        // Csak a category_id hozzáadása a már létező 'events' táblához
        Schema::table('events', function (Blueprint $table) {
            // Ellenőrizzük, hogy az oszlop még nincs-e hozzáadva
            if (!Schema::hasColumn('events', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('location')->constrained()->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'category_id')) {
                $table->dropForeign(['category_id']); 
                $table->dropColumn('category_id');
            }
        });
    }
};
