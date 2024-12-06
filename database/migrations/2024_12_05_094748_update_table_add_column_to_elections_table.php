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
        Schema::table('electeurs', function (Blueprint $table) {
            $table->string("province");
            $table->string("commoudept");
            $table->string("arrondissement")->nullable();
            $table->string("siege")->nullable();
            $table->string("nom")->index()->change();
            $table->string("prenom")->index()->change();
            $table->string("date_naiss")->index()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('electeurs', function (Blueprint $table) {
            $table->dropColumn("province");
            $table->dropColumn("commoudept");
            $table->dropColumn("arrondissement");
            $table->dropColumn("siege");
            $table->string("nom")->change();
            $table->string("prenom")->change();
            $table->string("date_naiss")->change();
        });
    }
};
