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
    Schema::create('treatments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('appointment_id');
        $table->unsignedBigInteger('vet_id');
        $table->unsignedBigInteger('pet_id');
        $table->text('diagnosis');
        $table->text('medication');
        $table->text('outcome')->nullable();
        $table->string('status')->default('completed'); // optional field to check if completed
        $table->timestamps();

        $table->foreign('appointment_id')->references('id')->on('appointments')->onDelete('cascade');
        $table->foreign('vet_id')->references('id')->on('vets')->onDelete('cascade');
        $table->foreign('pet_id')->references('id')->on('pets')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatments');
    }
};
