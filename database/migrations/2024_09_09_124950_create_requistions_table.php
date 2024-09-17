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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id'); // Program Staff who creates the requisition
            $table->unsignedBigInteger('program_id'); // Program for which the requisition is made
            $table->unsignedBigInteger('activity_id')->nullable(); // Activity for which the requisition is made
            $table->string('code')->unique(); // Unique requisition code
            $table->text('concept_note')->nullable();
            $table->text('description')->nullable(); // Description of the requisition
            $table->decimal('amount', 15, 2); // Total amount requested
            $table->decimal('amended_amount', 15, 2)->nullable(); // New total amount after amendments by finance
            $table->text('amended_items')->nullable(); // Amendments made by finance (items and amounts)
            $table->text('amendment_notes')->nullable(); // Additional notes or justifications for amendments by finance
            $table->enum('status', ['pending', 'approved', 'rejected', 'needs_info', 'amended'])->default('pending');
            $table->text('comment')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('head_of_finance')->nullable();
            $table->unsignedBigInteger('country_director')->nullable();
            $table->timestamps();
    
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->foreign('activity_id')->references('id')->on('activities')->onDelete('set null');
            $table->foreign('head_of_finance')->references('id')->on('staff')->onDelete('set null');
            $table->foreign('country_director')->references('id')->on('staff')->onDelete('set null');
            
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requistions');
    }
};
