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
        Schema::create('commet_arrondissements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("arrondissement_id");
            $table->foreign("arrondissement_id")->references("id")->on("arrondissements");
            $table->unsignedBigInteger("commoudept_id");
            $table->foreign("commoudept_id")->references("id")->on("commoudepts");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commet_arrondissements');
    }
};
