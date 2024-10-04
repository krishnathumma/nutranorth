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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('task_category');
            $table->string('task_type');
            $table->tinyInteger('assigned_to');
            $table->text('description');
            $table->string('source');
            $table->date('assigned_date');
            $table->string('filename');
            $table->date('due_time');
            $table->string('status');
            $table->bigInteger("created_by")->unsigned();
            $table->foreign("created_by")->references("id_user")->on("users")->onDelete("cascade");
            $table->bigInteger("updated_by")->unsigned();
            $table->foreign("updated_by")->references("id_user")->on("users")->onDelete("cascade");
            $table->bigInteger("deleted_by")->unsigned();
            $table->foreign("deleted_by")->references("id_user")->on("users")->onDelete("cascade");
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
