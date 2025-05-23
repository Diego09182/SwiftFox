<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('tag');
            $table->integer('view')->default(0);
            $table->integer('like')->default(0);
            $table->integer('dislike')->default(0);
            $table->text('keywords')->nullable();
            $table->string('sentiment')->nullable();
            $table->text('summary')->nullable();
            $table->boolean('violated')->default(false);
            $table->text('violation_reasons')->nullable();
            $table->string('category')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
