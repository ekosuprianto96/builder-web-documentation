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
        Schema::create('module_roles', function (Blueprint $table) {
            $table->id();
            $table->uuid('primary_modules');
            $table->foreign('primary_modules')->references('primary_modules')->on('modules')->onDelete('cascade')->onUpdate('cascade');
            $table->uuid('uuid_role');
            $table->foreign('uuid_role')->references('uuid')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('module_roles');
    }
};
