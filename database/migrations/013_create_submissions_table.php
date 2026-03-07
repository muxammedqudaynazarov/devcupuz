<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_id')->constrained('problems')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->string('uuid');
            $table->text('code');
            $table->string('time');
            $table->string('memory');
            $table->string('token')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['0', '1', '2', '3', '4'])->default('0');
            // process, accepted, error
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
