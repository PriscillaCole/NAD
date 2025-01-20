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
        Schema::table('accountabilities', function (Blueprint $table) {
            $table->foreign(['requisition_id'])->references(['id'])->on('requisitions')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['staff_id'])->references(['id'])->on('staff')->onUpdate('restrict')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accountabilities', function (Blueprint $table) {
            $table->dropForeign('accountabilities_requisition_id_foreign');
            $table->dropForeign('accountabilities_staff_id_foreign');
        });
    }
};
