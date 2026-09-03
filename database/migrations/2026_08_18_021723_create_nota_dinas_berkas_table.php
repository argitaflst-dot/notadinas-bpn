<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nota_dinas_berkas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nota_dinas_id')
                ->constrained('nota_dinas')
                ->cascadeOnDelete();

            $table->foreignId('berkas_id')
                ->constrained('berkas')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_dinas_berkas');
    }
};
