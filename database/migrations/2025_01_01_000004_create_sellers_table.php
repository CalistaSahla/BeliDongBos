<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sellers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_toko', 150);
            $table->string('nama_pic', 100);
            $table->string('kontak_pic', 50);
            $table->text('alamat_toko');
            $table->foreignId('city_id')->constrained()->onDelete('restrict');
            $table->foreignId('province_id')->constrained()->onDelete('restrict');
            $table->string('nomor_hp', 20);
            $table->string('email', 100);
            $table->string('foto_ktp', 255)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_reason')->nullable();
            $table->string('activation_token', 100)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('city_id');
            $table->index('province_id');
            $table->index('status');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
