<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Drops old appointment system tables that are no longer needed.
     * These tables were part of the old manual appointment booking system
     * that has been replaced by the new BookingAppointment system (synced from Bansal website).
     */
    public function up(): void
    {
        // Drop tables in reverse dependency order to avoid foreign key constraint issues
        
        // 1. Drop book_service_disable_slots (may have foreign keys to book_service_slot_per_persons)
        Schema::dropIfExists('book_service_disable_slots');
        
        // 2. Drop book_service_slot_per_persons (may have foreign keys to book_services)
        Schema::dropIfExists('book_service_slot_per_persons');
        
        // 3. Drop book_services (old booking service configuration)
        Schema::dropIfExists('book_services');
        
        // 4. Drop tbl_paid_appointment_payment (old payment tracking table)
        // Payment information is now stored directly in booking_appointments table
        Schema::dropIfExists('tbl_paid_appointment_payment');
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This migration does not recreate the tables as they are part of
     * the old system that has been completely replaced. If you need to rollback,
     * you would need to restore from a database backup.
     */
    public function down(): void
    {
        // Tables are not recreated as they are part of the deprecated old system.
        // If rollback is needed, restore from database backup.
    }
};
