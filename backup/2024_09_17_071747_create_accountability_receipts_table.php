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
        Schema::create('accountability_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('accountability_id');
            $table->string('receipt_path')->nullable();
           
            $table->foreign('accountability_id')->references('id')->on('accountabilities')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountability_receipts');
    }
};
