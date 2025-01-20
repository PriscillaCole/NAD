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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisition_item_id')->index('requisition_item_receipts_requisition_item_id_foreign');
            $table->unsignedBigInteger('accountability_id')->index('requisition_item_receipts_accountability_id_foreign');
            $table->string('receipt_file', 225)->nullable();
            $table->string('payment_proof', 225)->nullable();
            $table->string('Invoice', 225)->nullable();
            $table->decimal('amount', 15);
            $table->timestamps();
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
