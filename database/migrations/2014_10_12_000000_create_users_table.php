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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('account')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('avatar_filename')->nullable();
            $table->string('avatar_path')->nullable();
            $table->string('name');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('cellphone')->unique();
            $table->text('interest')->nullable();
            $table->string('url')->nullable();
            $table->text('info')->nullable();
            $table->string('club')->nullable();
            $table->date('birthday');
            $table->integer('times')->default(0);
            $table->integer('points')->default(0);
            $table->tinyInteger('administration')->default(0);
            $table->string('ip_address')->nullable();
            $table->timestamps();
            $table->tinyInteger('status')->default(1);
            $table->string('remember_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
