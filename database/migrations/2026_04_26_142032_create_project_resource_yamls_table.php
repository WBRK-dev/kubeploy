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
        Schema::create('project_resource_yamls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("project_resource_id");
            $table->text("yaml");
            $table->timestamps();

            $table->foreign("project_resource_id")->references("id")->on("project_resources")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_resource_yamls');
    }
};
