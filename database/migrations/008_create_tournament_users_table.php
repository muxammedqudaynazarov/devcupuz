<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tournament_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained('tournaments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('status', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->enum('active', ['0', '1'])->default('0');
            // yangi, qabul qilingan, chetlatilgan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_users');
    }
};
