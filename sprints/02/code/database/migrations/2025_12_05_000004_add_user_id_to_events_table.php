<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Logolás hozzáadása a hiba ellenőrzéséhez

return new class extends Migration
{
    /**
     * Futtatja a migrációt: hozzáadja az 'user_id' oszlopot, adatmegőrzéssel.
     */
    public function up(): void
    {
        // 1. lépés: Oszlop létrehozása (ha még nem létezik)
        if (!Schema::hasColumn('events', 'user_id')) {
            Schema::table('events', function (Blueprint $table) {
                Log::info('Adding user_id column to events table...');
                // Egyszerű oszlop hozzáadása, ideiglenesen nullable.
                $table->unsignedBigInteger('user_id')->nullable()->after('id'); 
            });
        }
        
        // 2. lépés: Adatok feltöltése
        // Dinamikusan lekérdezzük az első felhasználó ID-jét.
        $firstUserId = DB::table('users')->value('id'); 

        if ($firstUserId) {
            Log::info('Updating existing events with user_id: ' . $firstUserId);
            // A meglévő (NULL) user_id értékeket frissítjük a létező felhasználói ID-vel.
            DB::table('events')->whereNull('user_id')->update(['user_id' => $firstUserId]);
        } else {
            // Ez a log figyelmeztet, ha nincs felhasználó, de a kényszer felvételét 
            // csak akkor okozza a 3. lépésben a hibát, ha a tábla nem üres!
            Log::warning('No user found in the users table. Foreign key constraint might fail if events table is not empty.');
        }

        // 3. lépés: Kényszerek beállítása (NOT NULL és Foreign Key)
        Schema::table('events', function (Blueprint $table) {
            
            // 3a. Eltávolítjuk a NULL kényszert, így NOT NULL lesz.
            Log::info('Setting user_id to NOT NULL.');
            $table->unsignedBigInteger('user_id')->nullable(false)->change(); 

            // 3b. Hozzáadjuk a Foreign Key kényszert.
            Log::info('Adding Foreign Key constraint on user_id.');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Visszavonja a migrációt: eltávolítja az 'user_id' oszlopot.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Csak akkor próbáljuk meg eltávolítani, ha létezik az oszlop
            if (Schema::hasColumn('events', 'user_id')) {
                // Először töröljük az idegen kulcsot
                $table->dropForeign(['user_id']); 
                // Aztán töröljük az oszlopot
                $table->dropColumn('user_id');    
            }
        });
    }
};