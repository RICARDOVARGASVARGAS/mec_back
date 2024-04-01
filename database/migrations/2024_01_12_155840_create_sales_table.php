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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('number')->nullable();
            $table->string('km')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('exit_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->float('discount')->default(0);
            $table->enum('status', ['pending', 'done', 'cancelled', 'debt'])->default('pending');
            $table->string('observation')->nullable();
            $table->foreignId('client_id')->nullable()->constrained();
            $table->foreignId('car_id')->nullable()->constrained();
            $table->foreignId('company_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
