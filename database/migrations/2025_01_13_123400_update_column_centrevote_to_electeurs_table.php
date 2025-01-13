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
            $table->string("nip_ipn")->nullable()->change();
            $table->string("nom")->nullable()->change();
            $table->string("prenom")->nullable()->change();
            $table->string("date_naiss")->nullable()->change();
            $table->string("lieu_naiss")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('electeurs', function (Blueprint $table) {
            $table->string("nip_ipn");
            $table->string("nom");
            $table->string("prenom");
            $table->string("date_naiss");
            $table->string("lieu_naiss");
        });
    }
};
