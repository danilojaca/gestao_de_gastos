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
        Schema::create('economias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mes_id');
            $table->string('economia')->nullable();
            $table->string('ano');
            $table->timestamps();
            $table->foreign('mes_id')->references('id')->on('mes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('economias');
    }
};
