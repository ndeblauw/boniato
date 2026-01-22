<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('mollie_payment_id')->unique()->nullable();
            $table->foreignId('user_id');
            $table->foreignId('article_id');
            $table->integer('amount_cents');
            $table->enum('status', ['pending', 'paid', 'failed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
