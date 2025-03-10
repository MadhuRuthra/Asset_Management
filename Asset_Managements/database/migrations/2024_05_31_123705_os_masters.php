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
        Schema::create('os_masters', function (Blueprint $table) {
            $table->bigIncrements('os_master_id');

            $table->integer('user_id');
            $table->string('os_name', 30);
            $table->char('os_status', 1);
            $table->timestamp('os_entry_date')->nullable();
            $table->timestamp('os_modified_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('os_masters');
    }
};
