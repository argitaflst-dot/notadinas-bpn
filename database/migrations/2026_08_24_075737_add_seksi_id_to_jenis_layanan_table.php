<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jenis_layanan', function (Blueprint $table) {
            $table->foreign('seksi_id')
                ->references('id_seksi')
                ->on('seksi')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('jenis_layanan', function (Blueprint $table) {
            $table->dropForeign(['seksi_id']);
        });
    }
};