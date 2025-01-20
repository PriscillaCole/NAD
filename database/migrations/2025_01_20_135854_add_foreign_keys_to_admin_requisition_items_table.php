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
        Schema::table('admin_requisition_items', function (Blueprint $table) {
            $table->foreign(['admin_budget_line_id'])->references(['id'])->on('admin_budget_lines')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['requisition_id'])->references(['id'])->on('requisitions')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_requisition_items', function (Blueprint $table) {
            $table->dropForeign('admin_requisition_items_admin_budget_line_id_foreign');
            $table->dropForeign('admin_requisition_items_requisition_id_foreign');
        });
    }
};
