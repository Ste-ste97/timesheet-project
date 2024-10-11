<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_private')->default(0);
            $table->string('mobile_phone');
            $table->string('landline_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->unique();
            $table->string('postal_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
