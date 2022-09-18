<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('greek_name');
            $table->foreignId('country_id')->constrained();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('cities');
    }
};
