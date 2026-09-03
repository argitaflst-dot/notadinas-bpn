<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('nota_dinas')) {
            Schema::create('nota_dinas', function (Blueprint $table) {
                $table->id();
                $table->string('nomor');
                $table->year('tahun');
                $table->string('kepada');
                $table->string('dari');
                $table->date('tanggal');
                $table->text('keterangan')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_dinas');
    }
};
