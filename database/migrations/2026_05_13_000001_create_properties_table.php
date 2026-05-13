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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            
            // Client Info
            $table->string('client_name')->nullable();
            $table->string('client_no')->nullable();
            $table->string('client_phone')->nullable();
            $table->string('client_company')->nullable();
            $table->string('client_address')->nullable();
            $table->string('client_email')->nullable();

            // Tenant Info
            $table->string('tenant_name')->nullable();
            $table->string('tenant_no')->nullable();

            // Landlord Info
            $table->string('landlord_name')->nullable();
            $table->string('landlord_no')->nullable();
            $table->string('landlord_address')->nullable();
            $table->string('landlord_email')->nullable();

            // Compliance Dates
            $table->date('gas_cert_expiry')->nullable();
            $table->date('electric_cert_expiry')->nullable();
            $table->date('fire_alarm_expiry')->nullable();
            $table->date('emergency_light_expiry')->nullable();
            $table->date('epc_expiry')->nullable();
            $table->date('pat_testing_expiry')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
