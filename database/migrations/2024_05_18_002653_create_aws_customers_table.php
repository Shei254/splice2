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
        Schema::create('aws_customers', function (Blueprint $table) {
            $table->id();
            $table->string('aws_id')->unique();
            $table->unsignedInteger('user_id')->unique()->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete("CASCADE")->onUpdate("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aws_customers');
    }
};
