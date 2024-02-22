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
        Schema::create('calculates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('number')->nullable();
            $table->string('property_calculate')->nullable();
            $table->string('driver_calculate')->nullable();
            $table->string('ruc_calculate')->nullable();
            $table->string('dni_calculate')->nullable();
            $table->string('phone_calculate')->nullable();
            $table->string('cel_property_calculate')->nullable();
            $table->string('cel_driver_calculate')->nullable();
            $table->string('address_calculate')->nullable();
            $table->string('plate_calculate')->nullable();
            $table->string('engine_calculate')->nullable();
            $table->string('chassis_calculate')->nullable();
            $table->string('brand_calculate')->nullable();
            $table->string('model_calculate')->nullable();
            $table->string('year_car_calculate')->nullable();
            $table->string('color_calculate')->nullable();
            $table->string('km_calculate')->nullable();
            $table->string('observation_calculate')->nullable();
            $table->foreignId('company_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculates');
    }
};
