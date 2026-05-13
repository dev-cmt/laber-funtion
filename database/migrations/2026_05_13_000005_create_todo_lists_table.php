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
        Schema::create('todo_lists', function (Blueprint $table) {
            $table->id();
            $table->timestamp('entry_date')->useCurrent();
            $table->dateTime('due_date')->nullable();
            $table->enum('type', ['Appointment', 'To-Do'])->default('To-Do');
            $table->string('location')->nullable();
            $table->enum('status', ['Open', 'Done', 'Postponed'])->default('Open');
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo_lists');
    }
};
