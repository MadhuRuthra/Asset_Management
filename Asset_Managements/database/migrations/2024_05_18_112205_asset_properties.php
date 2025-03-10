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
        Schema::create('asset_properties', function (Blueprint $table) {
            $table->bigIncrements('asset_properties_id');

            $table->integer('asset_master_id');
            $table->integer('user_id');
            $table->integer('feature_id');
            $table->string('feature_name', 30);
            $table->char('feature_status', 1);
            $table->timestamp('feature_entry_date')->nullable();
            $table->timestamp('feature_modified_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_properties');
    }
};
