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
        Schema::create('accountabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisition_id'); 
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->string('narrative_report')->nullable(); // JSON field to store either text or file path
            $table->decimal('returned_amount', 15, 2)->nullable();// Funds returned by staff
            $table->string('proof_of_funds_returned')->nullable();
            $table->decimal('amount_to_be_returned',15, 2)->nullable();
            $table->string('proof_of_funds_to_be_returned')->nullable();
            $table->decimal('amount_used', 15, 2)->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
          

        
            $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('cascade');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('set null');
        });
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accountabilities');
    }
};
