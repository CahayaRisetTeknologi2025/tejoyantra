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
        Schema::create('ikr_installations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tower_id');
            $table->date('installation_date');
            $table->date('warranty_date');
            $table->string('customer_id',100)->index()->unique();
            $table->string('wo_id',100)->nullable();
            $table->string('customer_name');
            $table->string('contact_person')->nullable();
            $table->string('floor',100);
            $table->string('unit',100);
            $table->enum('status_work',['MIGRASI','INSTALASI','TROUBLESHOOTING', 'RELOKASI'])->default('INSTALASI');
            $table->enum('status', ['DONE', 'PENDING', 'CANCEL'])->default('PENDING');
            $table->string('team_name',100);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('tower_id')->references('id')->on('towers')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ikr_installations');
    }
};
