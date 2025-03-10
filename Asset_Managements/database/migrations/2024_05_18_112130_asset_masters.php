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
        Schema::create('asset_masters', function (Blueprint $table) {
            $table->bigIncrements('asset_master_id');

            $table->integer('user_id');
            $table->string('asset_name', 30);
            $table->string('asset_serial_no', 40);
            $table->string('asset_type', 20)->nullable();
            $table->string('asset_brand', 30);
            $table->string('asset_model_name', 30)->nullable();
            $table->char('asset_status', 1);
            $table->timestamp('purchase_date');
            $table->timestamp('asset_entry_date')->nullable();
            $table->timestamp('asset_modified_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_masters');
    }
};
