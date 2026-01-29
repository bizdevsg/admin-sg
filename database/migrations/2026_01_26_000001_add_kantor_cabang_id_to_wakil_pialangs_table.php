<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wakil_pialangs', function (Blueprint $table) {
            $table
                ->foreignId('kantor_cabang_id')
                ->nullable()
                ->after('id')
                ->constrained('kantor_cabangs')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('wakil_pialangs', function (Blueprint $table) {
            $table->dropConstrainedForeignId('kantor_cabang_id');
        });
    }
};

