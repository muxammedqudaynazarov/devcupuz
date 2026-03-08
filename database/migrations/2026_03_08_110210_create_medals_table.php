<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medals', function (Blueprint $table) {
            $table->id();
            $table->json('name'); // Medal nomi (Masalan: "Raxmat", "Oltin", "100 ta masala")
            $table->json('desc')->nullable(); // Ta'rifi
            $table->string('type'); // Toifasi: 'verify', 'score', 'problem_count', 'special'
            $table->integer('requirement')->default(0); // Shart qiymati: 250 (ball) yoki 15 (masala)
            $table->string('color_class')->nullable(); // Dizayn uchun CSS class (Masalan: badge-gold)
            $table->string('image')->nullable(); // Agar rasm ishlatilsa
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medals');
    }
};
