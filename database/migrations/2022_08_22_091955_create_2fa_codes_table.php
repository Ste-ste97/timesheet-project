<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (config('template.enable_2fa')) {
            Schema::create('2fa_codes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->unique()->constrained();
                $table->string('code');
                $table->dateTime('expires_at');
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('2fa_codes');
    }
};
