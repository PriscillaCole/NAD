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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisition_id')->index('admin_requisition_items_requisition_id_foreign');
            $table->unsignedBigInteger('admin_budget_line_id')->index('admin_requisition_items_admin_budget_line_id_foreign');
            $table->integer('quantity');
            $table->string('unit_of_measure');
            $table->decimal('unit_price', 10);
            $table->decimal('total_price', 10)->nullable();
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
