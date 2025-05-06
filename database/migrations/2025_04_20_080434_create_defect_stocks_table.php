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
        Schema::create('defect_stocks', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->text('date')->nullable();  
            $table->text('description')->nullable();  
            $table->string('picture_1')->nullable(); 
            $table->string('picture_2')->nullable(); 
            $table->unsignedBigInteger('id_inventory'); 
            $table->foreign('id_inventory')->references('id')->on('inventories')->onDelete('cascade');
            $table->string('created_with')->nullable();
            $table->string('updated_with')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defect_stocks');
    }
};
