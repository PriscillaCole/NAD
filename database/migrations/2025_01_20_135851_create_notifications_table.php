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
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedInteger('receiver_id')->nullable()->index('notifications_receiver_id_foreign');
            $table->unsignedInteger('role_id')->nullable()->index('notifications_role_id_foreign');
            $table->text('message')->nullable();
            $table->text('form_link')->nullable();
            $table->text('link')->nullable();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
