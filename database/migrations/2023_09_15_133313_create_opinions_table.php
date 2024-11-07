<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('opinions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->integer('agree')->default(0);
            $table->integer('disagree')->default(0);
            $table->integer('count')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamp('finished_time')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id')->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opinions');
    }
};
