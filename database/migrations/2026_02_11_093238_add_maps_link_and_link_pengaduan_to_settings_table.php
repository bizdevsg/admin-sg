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
        Schema::table('settings', function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'maps_link')) {
                $table->string('maps_link', 255)->nullable()->after('address');
            }
            if (!Schema::hasColumn('settings', 'link_pengaduan')) {
                $table->string('link_pengaduan', 255)->nullable()->after('maps_link');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'link_pengaduan')) {
                $table->dropColumn('link_pengaduan');
            }
            if (Schema::hasColumn('settings', 'maps_link')) {
                $table->dropColumn('maps_link');
            }
        });
    }
};
