<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Drops the old appointments and appointment_logs tables.
     * 
     * WARNING: These tables are still referenced in some code files:
     * - app/Http/Controllers/CRM/ClientsController.php (client merge function)
     * - app/Http/Controllers/API/ClientPortalDashboardController.php (client portal)
     * - app/Http/Controllers/CRM/AssigneeController.php (appointment_logs)
     * 
     * These code references should be updated to use booking_appointments
     * before or after running this migration.
     */
    public function up(): void
    {
        // Drop appointment_logs first (may have foreign key to appointments)
        Schema::dropIfExists('appointment_logs');
        
        // Drop appointments table (old appointment system)
        Schema::dropIfExists('appointments');
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
