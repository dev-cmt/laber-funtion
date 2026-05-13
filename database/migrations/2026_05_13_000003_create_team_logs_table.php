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
        Schema::create('team_logs', function (Blueprint $table) {
            $table->id();
            $table->string('member_name');
            $table->date('date');
            $table->foreignId('site_id')->constrained('properties')->onDelete('cascade');
            $table->enum('shift_type', ['Full', 'Half'])->default('Full');
            $table->decimal('daily_pay', 15, 2)->default(0);
            $table->boolean('is_paid')->default(false);

            // Attachments
            $table->json('receipt_links')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_logs');
    }
};
