<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary()->unique();
            $table->text('name');
            $table->text('logo');
            $table->text('client_id');
            $table->text('client_secret');
            $table->text('hemis_url');
            $table->text('hemis_student_url');
            $table->enum('status', ['0', '1', '2', '3', '4', '5'])->default('0');
            $table->timestamp('activated_to')->nullable();
            // 0 - Taqiqlangan, 1 - Ruxsat, 2 - Ko'rib chiqilmoqda, 3 - Tekshiruvda, 4 - Maqullandi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};
