<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrizeRedemptionsTable extends Migration
{
    public function up(): void
    {
        Schema::create('prize_redemptions', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity')->default(1);
            $table->string('status')->default('pending');
            $table->text('note')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('prize_id')->constrained()->onDelete('cascade');
            $table->string('shipping_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prize_redemptions');
    }
}
