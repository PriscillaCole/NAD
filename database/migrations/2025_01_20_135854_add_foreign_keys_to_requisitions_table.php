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
        Schema::table('requisitions', function (Blueprint $table) {
            $table->foreign(['activity_id'])->references(['id'])->on('activities')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['admin_program_id'], 'requisitions_admin-program_id_foreign')->references(['id'])->on('admin_programs')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['country_director'])->references(['id'])->on('staff')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['head_of_finance'])->references(['id'])->on('staff')->onUpdate('restrict')->onDelete('set null');
            $table->foreign(['program_id'])->references(['id'])->on('programs')->onUpdate('restrict')->onDelete('cascade');
            $table->foreign(['staff_id'])->references(['id'])->on('staff')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropForeign('requisitions_activity_id_foreign');
            $table->dropForeign('requisitions_admin-program_id_foreign');
            $table->dropForeign('requisitions_country_director_foreign');
            $table->dropForeign('requisitions_head_of_finance_foreign');
            $table->dropForeign('requisitions_program_id_foreign');
            $table->dropForeign('requisitions_staff_id_foreign');
        });
    }
};
