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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->nullable();
            $table->integer('staff_number')->nullable();
            $table->string('nin_number')->nullable()->nullable();
            $table->string('name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('home_district')->nullable();
            $table->string('title')->nullable();
            $table->string('contract_start')->nullable();
            $table->string('contract_end')->nullable();
            $table->string('project')->nullable();
            $table->string('region')->nullable();
            $table->string('duty_station')->nullable();
            $table->string('line_manager')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('bank')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('tin')->nullable();
            $table->string('nssf')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('next_of_kin')->nullable();
            $table->string('contact_of_kin')->nullable();
            $table->string('relationship')->nullable();
            $table->string('profile_picture')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('admin_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
