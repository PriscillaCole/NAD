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
        Schema::table('budget_lines', function (Blueprint $table) {
            $table->string('units')->nullable()->after('frequency');
            $table->bigInteger('dev_Vs_Org')->nullable()->after('budget');
            
        });

        Schema::table('admin_budget_lines', function (Blueprint $table) {
            $table->bigInteger('dev_Vs_Org')->nullable()->after('total_cost');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('budget_lines', function (Blueprint $table) {
            //
        });
    }
};
