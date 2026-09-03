<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_layanan_id')
                ->constrained('jenis_layanan')
                ->cascadeOnDelete();

            $table->string('no_berkas');
            $table->date('tanggal_pendaftaran')->nullable();

            $table->string('no_hak')->nullable();
            $table->string('nib_elektronik')->nullable();

            $table->string('pemohon');

            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->string('nomor_akta')->nullable();
            $table->date('tanggal_akta')->nullable();

            $table->string('ppat')->nullable();

            $table->string('desa_kelurahan')->nullable();
            $table->string('kecamatan')->nullable();

            $table->decimal('luas', 12, 2)->nullable();

            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
