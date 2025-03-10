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
        Schema::create('version_masters', function (Blueprint $table) {
            $table->bigIncrements('version_master_id');

            $table->integer('os_master_id');
            $table->integer('user_id');
            $table->string('version_type', 30)->nullable();
            $table->string('version_name', 20);
            $table->char('version_status', 1)->nullable();  
            $table->timestamp('version_entry_date')->nullable();
            $table->timestamp('version_modified_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('version_masters');
    }
};
