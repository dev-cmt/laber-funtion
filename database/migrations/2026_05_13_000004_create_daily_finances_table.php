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
        Schema::create('daily_finances', function (Blueprint $table) {
            $table->id();
            $table->string('expense_type'); // Category
            $table->foreignId('site_id')->nullable()->constrained('properties')->onDelete('set null');
            $table->date('date');

            // Cash Flow
            $table->decimal('cash_out', 15, 2)->default(0);
            $table->decimal('cash_in', 15, 2)->default(0);
            $table->decimal('cash_refund', 15, 2)->default(0);

            // Account Flow
            $table->decimal('acc_out', 15, 2)->default(0);
            $table->decimal('acc_in', 15, 2)->default(0);
            $table->decimal('acc_refund', 15, 2)->default(0);

            $table->json('invoice_references')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_finances');
    }
};
