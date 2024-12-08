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
        Schema::table('identifications', function (Blueprint $table) {
            $table->dropColumn("province");
            $table->dropColumn("commoudept");
            $table->dropColumn("arrondissement");
            $table->unsignedBigInteger("arrondissement_id")->nullable()->index();
            $table->foreign("arrondissement_id")->references("id")->on("arrondissements");
            $table->unsignedBigInteger("commoudept_id")->index();
            $table->foreign("commoudept_id")->references("id")->on("commoudepts");
            $table->unsignedBigInteger("province_id")->index();
            $table->foreign("province_id")->references("id")->on("provinces")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identifications', function (Blueprint $table) {
            $table->string("province");
            $table->string("commoudept");
            $table->string("arrondissement")->nullable();
            $table->dropForeign("arrondissement_id");
            $table->dropColumn("arrondissement_id");
            $table->dropForeign("commoudept_id");
            $table->dropColumn("commoudept_id");
            $table->dropForeign("province_id");
            $table->dropColumn("province_id");

        });
    }
};
