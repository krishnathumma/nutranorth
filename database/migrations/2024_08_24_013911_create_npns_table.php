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
        Schema::create('npns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('status');
            $table->integer('number');
            $table->integer('location');
            $table->string('filename');
            $table->bigInteger("created_by")->unsigned();
            $table->foreign("created_by")->references("id_user")->on("users")->onDelete("cascade");
            $table->bigInteger("updated_by")->unsigned();
            $table->foreign("updated_by")->references("id_user")->on("users")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('npns');
    }
};
