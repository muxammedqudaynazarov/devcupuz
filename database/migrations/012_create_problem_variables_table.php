<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('problem_variables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_id')->constrained('problems')->cascadeOnDelete();
            $table->text('input');
            $table->text('output');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('problem_variables');
    }
};
