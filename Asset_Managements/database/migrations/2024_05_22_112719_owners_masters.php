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
        Schema::create('owners_masters', function (Blueprint $table) {
            $table->bigIncrements('owner_master_id');

            $table->integer('user_id');
            $table->string('owner_name', 30);
            $table->string('owner_id', 30)->nullable();
            $table->string('owner_role', 50)->nullable();
            $table->char('owner_status', 1);
            $table->timestamp('owner_entry_date')->nullable();
            $table->timestamp('owner_modified_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('owners_masters');
    }
};
