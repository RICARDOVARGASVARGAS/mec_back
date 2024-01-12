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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('plate');
            $table->string('engine')->nullable();
            $table->string('chassis')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('client_id')->constrained();
            $table->foreignId('example_id')->constrained();
            $table->foreignId('color_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('year_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
