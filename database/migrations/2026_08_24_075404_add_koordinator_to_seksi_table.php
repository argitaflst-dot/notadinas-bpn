<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seksi', function (Blueprint $table) {
            if (! Schema::hasColumn('seksi', 'nama_koordinator')) {
                $table->string('nama_koordinator')->nullable()->after('nama_seksi');
            }

            if (! Schema::hasColumn('seksi', 'nip_koordinator')) {
                $table->string('nip_koordinator')->nullable()->after('nama_koordinator');
            }
        });
    }

    public function down(): void
    {
        Schema::table('seksi', function (Blueprint $table) {
            if (Schema::hasColumn('seksi', 'nip_koordinator')) {
                $table->dropColumn('nip_koordinator');
            }

            if (Schema::hasColumn('seksi', 'nama_koordinator')) {
                $table->dropColumn('nama_koordinator');
            }
        });
    }
};
