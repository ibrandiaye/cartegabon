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
        Schema::table('centrevotes', function (Blueprint $table) {
            $table->unsignedBigInteger("commoudept_id");
            $table->foreign("commoudept_id")->references("id")->on("commoudepts")->onDelete("cascade");

            $table->unsignedBigInteger("arrondissement_id")->nullable();
            $table->foreign("arrondissement_id")->references("id")->on("arrondissements")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('centrevotes', function (Blueprint $table) {
            $table->dropForeign("commoudept_id");
            $table->dropColumn("commoudept_id");
            $table->dropForeign("arrondissement_id");
            $table->dropColumn("arrondissement_id");
        });
    }
};
