<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('nama', 100);
            $table->string('nomor_hp', 20);
            $table->string('email', 100);
            $table->tinyInteger('rating')->unsigned();
            $table->text('komentar');
            $table->foreignId('province_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
            
            $table->index('product_id');
            $table->index('rating');
            $table->index('province_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
