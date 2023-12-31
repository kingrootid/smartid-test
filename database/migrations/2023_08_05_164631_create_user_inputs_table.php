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
        Schema::create('user_inputs', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->integer('user_id');
            $table->uuid('schedule_input_uuid');
            $table->uuid('sub_klaster_uuid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_inputs');
    }
};
