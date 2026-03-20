<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->string('username')->unique();
            $table->text('password');
            $table->string('phone')->nullable()->unique();
            $table->string('pos')->default('user');
            $table->json('rol')->default(json_encode(['user']));
            $table->text('image')->nullable();
            $table->foreignId('university_id')->nullable()->constrained('universities')->cascadeOnDelete();
            $table->enum('status', ['0', '1', '2', '3', '4', '5'])->default('0');
            // 0 - Yangi, 1 - Tasdiqlangan, 2 - Taqiqlangan, 3 - Ban
            $table->string('theme')->default('dark.css');
            $table->integer('per_page')->default(20);
            $table->string('language')->default('uz');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
