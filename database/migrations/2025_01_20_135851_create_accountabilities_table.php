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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('requisition_id')->index('accountabilities_requisition_id_foreign');
            $table->unsignedBigInteger('staff_id')->nullable()->index('accountabilities_staff_id_foreign');
            $table->string('narrative_report')->nullable();
            $table->decimal('returned_amount', 15)->nullable();
            $table->string('proof_of_funds_returned')->nullable();
            $table->decimal('amount_to_be_returned', 15)->nullable();
            $table->string('proof_of_funds_to_be_returned')->nullable();
            $table->decimal('amount_used', 15)->nullable();
            $table->string('status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('signature')->nullable();
            $table->timestamps();
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
