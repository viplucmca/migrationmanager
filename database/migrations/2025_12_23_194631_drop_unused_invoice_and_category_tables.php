<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Drops unused invoice, category, and email template tables.
     * These tables are either legacy, unused, or have been replaced by newer systems.
     */
    public function up(): void
    {
        // Disable foreign key checks temporarily to allow dropping tables
        // even if they have foreign key constraints
        Schema::disableForeignKeyConstraints();
        
        try {
            // Drop unused category and item tables
            Schema::dropIfExists('categories');
            Schema::dropIfExists('items');
            
            // Drop legacy invoice tables (replaced by account_client_receipts)
            Schema::dropIfExists('invoice_schedules');
            Schema::dropIfExists('invoice_followups');
            Schema::dropIfExists('invoice_payments');
            Schema::dropIfExists('invoice_details');
            Schema::dropIfExists('invoices');
            
            // Drop email_templates table (user requested)
            Schema::dropIfExists('email_templates');
        } finally {
            // Re-enable foreign key checks
            Schema::enableForeignKeyConstraints();
        }
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This migration drops tables, so rollback is not possible without
     * recreating the table structures. If you need to rollback, you would need
     * to restore from a database backup.
     */
    public function down(): void
    {
        // Cannot recreate dropped tables without their original structure
        // If rollback is needed, restore from database backup
    }
};
