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
        
        Schema::create('admin_requisition_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('requisition_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_budget_line_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->string('unit_of_measure');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_requisition_items');
    }
};
