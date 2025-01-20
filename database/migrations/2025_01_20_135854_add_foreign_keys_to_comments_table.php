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
        Schema::table('comments', function (Blueprint $table) {
            $table->foreign(['commented_by'])->references(['id'])->on('staff')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['requisition_id'])->references(['id'])->on('requisitions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign('comments_commented_by_foreign');
            $table->dropForeign('comments_requisition_id_foreign');
        });
    }
};
