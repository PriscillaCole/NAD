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
        Schema::create('requisition_item_receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisition_item_id');
            $table->unsignedBigInteger('accountability_id');
            $table->string('receipt_file');
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->timestamps();

            $table->foreign('requisition_item_id')->references('id')->on('requisition_items')->onDelete('cascade');
            $table->foreign('accountability_id')->references('id')->on('accountabilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisition_item_receipts');
    }
};
