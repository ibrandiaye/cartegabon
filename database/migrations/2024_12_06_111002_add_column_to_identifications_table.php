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
            $table->string("prenom");
            $table->string("nom");
            $table->string("lieunaiss");
            $table->date("datenaiss");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('identifications', function (Blueprint $table) {
            $table->dropColumn("prenom");
            $table->dropColumn("nom");
            $table->dropColumn("datenaiss");
            $table->dropColumn("lieunaiss");

        });
    }
};
