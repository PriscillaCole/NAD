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
        Schema::table('outcomes', function (Blueprint $table) {
            $table->bigInteger('Second_budget')->nullable()->after('budget');
            $table->bigInteger('third_budget')->nullable()->after('Second_budget');

        });
        Schema::table('outputs', function (Blueprint $table) {
            $table->bigInteger('Second_budget')->nullable()->after('budget');
            $table->bigInteger('third_budget')->nullable()->after('Second_budget');
        });
        Schema::table('activities', function (Blueprint $table) {
            $table->bigInteger('Second_budget')->nullable()->after('budget');
            $table->bigInteger('third_budget')->nullable()->after('Second_budget');
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            //
        });
    }
};
