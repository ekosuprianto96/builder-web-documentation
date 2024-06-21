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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('primary_menu')->unique();
            $table->string('primary_modules');
            $table->foreign('primary_modules')->references('primary_modules')->on('modules');
            $table->bigInteger('icon');
            $table->foreign('icon')->references('id')->on('icons');
            $table->string('name');
            $table->string('url');
            $table->integer('an')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
