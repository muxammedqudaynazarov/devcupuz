<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->text('desc');
            $table->timestamp('started');
            $table->timestamp('finished');
            $table->timestamp('deadline');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['0', '1', '2', '3', '4', '5'])->default('0');
            // Nonactive, active, process, finished, canceled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
