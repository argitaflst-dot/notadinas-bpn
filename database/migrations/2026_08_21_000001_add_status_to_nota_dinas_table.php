<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('nota_dinas', 'status')) {
            Schema::table('nota_dinas', function (Blueprint $table) {
                $table->string('status')->default('draft')->after('keterangan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('nota_dinas', 'status')) {
            Schema::table('nota_dinas', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
};
