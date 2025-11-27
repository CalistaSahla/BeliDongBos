<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->string('nama_produk', 200);
            $table->string('slug', 220)->unique();
            $table->text('deskripsi');
            $table->decimal('harga', 15, 2);
            $table->integer('stok')->default(0);
            $table->string('berat', 50)->nullable();
            $table->string('kondisi', 20)->default('baru');
            $table->string('min_pembelian', 10)->default('1');
            $table->string('etalase', 100)->nullable();
            $table->string('foto_utama', 255)->nullable();
            $table->json('foto_galeri')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->timestamps();
            
            $table->index('seller_id');
            $table->index('category_id');
            $table->index('stok');
            $table->index('is_active');
            $table->index('rating_avg');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
