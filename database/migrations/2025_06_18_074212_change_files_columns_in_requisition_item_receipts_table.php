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
        Schema::table('requisition_item_receipts', function (Blueprint $table) {
            $table->json('receipt_file')->nullable()->change();
            $table->json('payment_proof')->nullable()->change();
            $table->json('Invoice')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisition_item_receipts', function (Blueprint $table) {
            // $table->dropColumn('receipt_file');
            // $table->dropColumn('payment_proof');
            // $table->dropColumn('Invoice');
        });
    }
};
