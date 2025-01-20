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
        Schema::table('admin_activities', function (Blueprint $table) {
            $table->foreign(['admin_program_id'])->references(['id'])->on('admin_programs')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_activities', function (Blueprint $table) {
            $table->dropForeign('admin_activities_admin_program_id_foreign');
        });
    }
};
