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
        Schema::create('asset_managers', function (Blueprint $table) {
            $table->bigIncrements('asset_manager_id');

            $table->integer('asset_master_id');
            $table->integer('user_id');
            $table->string('asset_details');
            $table->string('assigned_to', 30)->nullable();
            $table->char('assigned_status', 1);
            $table->timestamp('assigned_entry_date')->nullable();
            $table->timestamp('assigned_modified_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_managers');
    }
};
