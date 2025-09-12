<?php

use Encore\Admin\Form\Field\Nullable;
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
        Schema::table('activities', function (Blueprint $table) {
            $table->foreignId('program_id')->nullable()->after('id');
            $table->bigInteger('dev_Vs_Org')->nullable()->after('budget');
            
        });
        Schema::table('admin_activities', function (Blueprint $table) {
            $table->bigInteger('dev_Vs_Org')->nullable()->after('budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity', function (Blueprint $table) {
            //
        });
    }
};
