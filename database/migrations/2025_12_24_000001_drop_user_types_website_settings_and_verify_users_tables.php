<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop user_types table
        // Note: user_roles.usertype column references user_types.id, but this is a model relationship only
        // No database foreign key constraint exists, so we can drop directly
        Schema::dropIfExists('user_types');
        
        // Drop website_settings table
        Schema::dropIfExists('website_settings');
        
        // Drop verify_users table
        Schema::dropIfExists('verify_users');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Note: Table structures are unknown, so we cannot recreate them in down().
        // If needed, you can add the table creation here later.
        // 
        // user_types table structure would be needed to recreate the relationship
        // website_settings and verify_users table structures are also unknown
    }
};

