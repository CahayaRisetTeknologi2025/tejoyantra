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
        Schema::table('ikr_installations', function (Blueprint $table) {
            $table->unsignedBigInteger('isp_id');

            $table->foreign('isp_id')->references('id')->on('isps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ikr_installations', function (Blueprint $table) {
            $table->dropForeign('ikr_installations_isp_id_foreign');
            $table->dropColumn('isp_id');
        });
    }
};
