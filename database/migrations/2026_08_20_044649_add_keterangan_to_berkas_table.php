<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('berkas', 'keterangan')) {
            Schema::table('berkas', function (Blueprint $table) {
                $table->string('keterangan')->nullable()->after('luas');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('berkas', 'keterangan')) {
            Schema::table('berkas', function (Blueprint $table) {
                $table->dropColumn('keterangan');
            });
        }
    }
};
