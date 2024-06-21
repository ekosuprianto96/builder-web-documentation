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
        Schema::create('project_temps', function (Blueprint $table) {
            $table->id();
            $table->string('uuid_project');
            $table->foreign('uuid_project')->references('uuid')->on('projects');
            $table->json('blocks');
            $table->json('pages');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_temps');
    }
};
