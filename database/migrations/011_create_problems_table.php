<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('desc');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('week_id')->constrained('weeks')->cascadeOnDelete();
            $table->json('input_text');
            $table->json('output_text');
            $table->text('example');
            $table->integer('memory')->default(16);
            $table->integer('runtime')->default(1);
            $table->integer('point')->default(20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('problems');
    }
};
