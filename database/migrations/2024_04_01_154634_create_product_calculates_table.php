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
        Schema::create('product_calculates', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->string('description');
            $table->string('brand')->nullable();
            $table->float('price');
            $table->foreignId('calculate_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_calculates');
    }
};
