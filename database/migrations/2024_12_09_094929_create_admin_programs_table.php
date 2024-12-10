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
        // Create the admin_programs table
        Schema::create('admin_programs', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Program name
            $table->text('description')->nullable(); 
            $table->integer('budget');
            $table->timestamps(); // Created and updated timestamps
        });

        // Create the budget_lines table
        Schema::create('admin_budget_lines', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('admin_program_id')->constrained()->onDelete('cascade'); // Foreign key to admin_programs
            $table->string('name'); // Name of the budget line
            $table->decimal('unit_cost', 15, 2); // Unit cost for the budget line
            $table->integer('quantity'); // Quantity for the budget line
            $table->integer('frequency'); // Frequency for the budget line
            $table->decimal('total_cost', 15, 2); // Total cost (unit_cost * quantity * frequency)
            $table->timestamps(); // Created and updated timestamps

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop budget_lines table first to avoid foreign key constraint issues
        Schema::dropIfExists('admin_budget_lines');
        Schema::dropIfExists('admin_programs');
    }
};
