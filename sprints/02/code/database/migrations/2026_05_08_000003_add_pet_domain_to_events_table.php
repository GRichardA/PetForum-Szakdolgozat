<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->json('allowed_animal_types')->nullable()->after('description');
            $table->json('allowed_breeds')->nullable()->after('allowed_animal_types');
            $table->boolean('vaccination_required')->default(false)->after('allowed_breeds');
            $table->unsignedInteger('capacity')->nullable()->after('vaccination_required');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['allowed_animal_types', 'allowed_breeds', 'vaccination_required', 'capacity']);
        });
    }
};