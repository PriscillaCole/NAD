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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('staff_id')->index('requisitions_staff_id_foreign');
            $table->unsignedBigInteger('program_id')->nullable()->index('requisitions_program_id_foreign');
            $table->unsignedBigInteger('admin_program_id')->nullable()->index('requisitions_admin-program_id_foreign');
            $table->unsignedBigInteger('activity_id')->nullable()->index('requisitions_activity_id_foreign');
            $table->string('code')->unique();
            $table->text('concept_note')->nullable();
            $table->text('description')->nullable();
            $table->decimal('amount', 15)->nullable();
            $table->decimal('amended_amount', 15)->nullable();
            $table->text('amended_items')->nullable();
            $table->text('amendment_notes')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'needs_info', 'amended', 'accepted'])->default('pending');
            $table->text('comment')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('head_of_finance')->nullable()->index('requisitions_head_of_finance_foreign');
            $table->unsignedBigInteger('country_director')->nullable()->index('requisitions_country_director_foreign');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
