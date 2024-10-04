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
        Schema::create('user_location_relationship', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id');
    		$table->tinyInteger('role_id');
    		$table->tinyInteger('location_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_location_relationship');
    }
};
