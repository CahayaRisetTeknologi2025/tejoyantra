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
        Schema::create('ikr_installation_onts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ikr_installation_id');
            $table->string('fat_code',100)->nullable();
            $table->string('port',50)->nullable();
            $table->string('drop_wire',50)->nullable();
            $table->string('pigtall',50)->nullable();
            $table->string('splicing',50)->nullable();
            $table->string('ont',50)->nullable();
            $table->string('serial_number',100)->nullable();
            $table->string('mac_number',100)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('ikr_installation_id')->references('id')->on('ikr_installations')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikr_installation_onts');
    }
};
