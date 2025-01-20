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
        Schema::table('accountability_receipts', function (Blueprint $table) {
            $table->foreign(['accountability_id'])->references(['id'])->on('accountabilities')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accountability_receipts', function (Blueprint $table) {
            $table->dropForeign('accountability_receipts_accountability_id_foreign');
        });
    }
};
