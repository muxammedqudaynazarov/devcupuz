<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->integer('week_number')->default(1);
            $table->timestamp('started');
            $table->timestamp('finished');
            $table->enum('status', ['0', '1', '2', '3', '4', '5'])->default('0');
            // Countdown, Active, Finished, Canceled
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weeks');
    }
};
