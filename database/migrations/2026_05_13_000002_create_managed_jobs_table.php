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
        Schema::create('managed_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->dateTime('scheduled_at')->nullable();
            $table->text('job_details')->nullable();

            // Financials
            $table->decimal('agreed_price', 15, 2)->default(0);
            $table->decimal('vat', 15, 2)->default(0);
            $table->decimal('total_price', 15, 2)->default(0);
            $table->decimal('cash_payment_received', 15, 2)->default(0);
            $table->decimal('acc_payment_received', 15, 2)->default(0);

            // Status
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Cancelled'])->default('Pending');

            // Resources
            $table->string('who_attended')->nullable();
            $table->text('tools_needed')->nullable();
            $table->text('materials_needed')->nullable();

            // Media
            $table->json('media_links')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('managed_jobs');
    }
};
