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
        Schema::create('image_masters', function (Blueprint $table) {
            $table->bigIncrements('image_master_id');

            $table->integer('user_id');
            $table->string('image_url')->nullable();
            $table->char('image_status', 1)->nullable();  
            $table->timestamp('image_entry_date')->nullable();
            $table->timestamp('image_modified_date')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_masters');
    }
};
