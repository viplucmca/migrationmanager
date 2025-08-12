<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->json('signature_doc_link')->nullable()->after('id');
            $table->string('signed_doc_link')->nullable()->after('signature_doc_link');
        });
    }

    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['signature_doc_link', 'signed_doc_link']);
        });
    }
}; 