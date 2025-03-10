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
        Schema::create('system_credentials', function (Blueprint $table) {
            $table->bigIncrements('credential_id');

            $table->integer('asset_master_id');
            $table->integer('user_id');
            $table->string('system_name', 30)->nullable();
            $table->string('user_name', 30)->nullable();
            $table->string('password', 30)->nullable();
            $table->string('root_password', 40)->nullable();
            $table->string('mysql_user_password')->nullable();
            $table->string('mongodb_user_password')->nullable();
            $table->char('credential_status', 1);
            $table->timestamp('credential_entry_date')->nullable();
            $table->timestamp('credential_modified_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
