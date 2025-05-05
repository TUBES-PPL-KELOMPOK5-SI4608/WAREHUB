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
        Schema::create('returs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('picture_1')->nullable(); 
            $table->string('picture_2')->nullable(); 
            $table->text('description')->nullable(); 
            $table->string('status')->nullable(); 
            $table->timestamps(); 

            $table->unsignedBigInteger('id_vendor');
            $table->string('created_with')->nullable();
            $table->string('updated_with')->nullable();
            $table->foreign('id_vendor')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returs');
    }
};
