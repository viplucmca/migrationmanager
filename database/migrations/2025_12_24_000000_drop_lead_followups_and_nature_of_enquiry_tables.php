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
        // Drop lead_followups table
        Schema::dropIfExists('lead_followups');
        
        // Drop nature_of_enquiry table (if it exists)
        Schema::dropIfExists('nature_of_enquiry');
        
        // Drop service_fee_options table
        Schema::dropIfExists('service_fee_options');
        
        // Drop service_fee_option_types table
        Schema::dropIfExists('service_fee_option_types');
        
        // Drop sub_categories table
        Schema::dropIfExists('sub_categories');
        
        // Drop test_scores table
        Schema::dropIfExists('test_scores');
        
        // Drop tasks table
        Schema::dropIfExists('tasks');
        
        // Drop users table
        Schema::dropIfExists('users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate lead_followups table
        Schema::create('lead_followups', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('lead_id');
            $table->unsignedInteger('assigned_to');
            $table->unsignedInteger('created_by');
            $table->enum('followup_type', ['call', 'email', 'meeting', 'sms', 'whatsapp', 'other']);
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->dateTime('scheduled_date');
            $table->dateTime('completed_at')->nullable();
            $table->enum('status', ['pending', 'completed', 'overdue', 'cancelled', 'rescheduled'])->default('pending');
            $table->enum('outcome', ['interested', 'not_interested', 'callback_later', 'converted', 'no_response'])->nullable();
            $table->dateTime('next_followup_date')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('reminder_sent')->default(false);
            $table->dateTime('reminder_sent_at')->nullable();
            $table->timestamps();
            
            // Foreign key constraints
            $table->foreign('lead_id')->references('id')->on('admins')->onDelete('cascade');
            $table->foreign('assigned_to')->references('id')->on('admins');
            $table->foreign('created_by')->references('id')->on('admins');
            
            // Indexes
            $table->index(['assigned_to', 'scheduled_date']);
            $table->index(['status', 'scheduled_date']);
        });
        
        // Note: nature_of_enquiry, service_fee_options, service_fee_option_types, sub_categories,
        // test_scores, tasks, and users table structures are unknown or intentionally removed,
        // so we cannot recreate them in down(). If needed, you can add the table creation here later
    }
};

