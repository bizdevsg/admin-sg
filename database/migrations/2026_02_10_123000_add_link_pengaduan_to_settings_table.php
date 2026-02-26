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
        if (! Schema::hasColumn('settings', 'link_pengaduan')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->string('link_pengaduan')->nullable()->after('maps_link');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('settings', 'link_pengaduan')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('link_pengaduan');
            });
        }
    }
};
