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
        Schema::table('sellers', function (Blueprint $table) {
            $table->text('deskripsi_singkat')->nullable()->after('nama_toko');
            $table->string('rt', 10)->nullable()->after('alamat_toko');
            $table->string('rw', 10)->nullable()->after('rt');
            $table->string('kelurahan', 100)->nullable()->after('rw');
            $table->string('no_ktp', 20)->nullable()->after('email');
            $table->string('foto_pic', 255)->nullable()->after('no_ktp');
        });
    }

    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_singkat', 'rt', 'rw', 'kelurahan', 'no_ktp', 'foto_pic']);
        });
    }
};
