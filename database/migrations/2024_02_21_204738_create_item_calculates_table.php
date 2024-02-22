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
        Schema::create('item_calculates', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_item');
            $table->string('description_item');
            $table->string('brand_item')->nullable();
            $table->float('price_item');
            $table->foreignId('calculate_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_calculates');
    }
};
