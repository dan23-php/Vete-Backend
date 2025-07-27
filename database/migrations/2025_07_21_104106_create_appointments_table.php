<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vet_id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('pet_id');
            $table->timestamp('appointment_time');
            $table->string('status')->default('scheduled'); // scheduled, completed, canceled
            $table->timestamps();

            $table->foreign('vet_id')->references('id')->on('vets')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
