<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Drops unused application-related tables:
     * - application_fee_option_types (depends on application_fee_options)
     * - application_fee_options
     * - application_activities_logs
     */
    public function up(): void
    {
        // Drop tables in dependency order
        // Drop application_fee_option_types first (it references application_fee_options)
        Schema::dropIfExists('application_fee_option_types');
        
        // Drop application_fee_options
        Schema::dropIfExists('application_fee_options');
        
        // Drop application_activities_logs
        Schema::dropIfExists('application_activities_logs');
    }

    /**
     * Reverse the migrations.
     * 
     * Note: This recreates the tables with their original structure.
     * If you need to restore data, you'll need to do that separately.
     */
    public function down(): void
    {
        // Recreate application_activities_logs
        Schema::create('application_activities_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('stage')->nullable();
            $table->string('comment')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->integer('app_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('description')->nullable();
            $table->string('title')->nullable();
            $table->string('type', 50)->nullable();
        });

        // Recreate application_fee_options
        Schema::create('application_fee_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->integer('app_id')->nullable();
            $table->string('name')->nullable();
            $table->string('country')->nullable();
            $table->string('installment_type')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('discount_sem', 10, 2)->nullable();
            $table->decimal('total_discount', 10, 2)->nullable();
        });

        // Recreate application_fee_option_types (depends on application_fee_options)
        Schema::create('application_fee_option_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fee_id')->nullable();
            $table->string('fee_type')->nullable();
            $table->decimal('inst_amt', 10, 2)->nullable();
            $table->integer('installment')->nullable();
            $table->decimal('total_fee', 10, 2)->nullable();
            $table->decimal('claim_term', 10, 2)->nullable();
            $table->decimal('commission', 10, 2)->nullable();
            $table->tinyInteger('quotation')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }
};
