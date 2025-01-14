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
        Schema::create('elects', function (Blueprint $table) {
            $table->id();
            $table->string("nip_ipn")->index();
            $table->string("nom")->index()->nullable();
            $table->string("prenom")->index()->nullable();
            $table->string("date_naiss")->nullable();
            $table->string("lieu_naiss")->nullable();
            $table->string("localisation")->nullable();
            $table->string("centrevote");
            $table->string("province");
            $table->string("commoudept");
            $table->string("siege");
            $table->unsignedBigInteger("centrevote_id")->index();
            $table->foreign("centrevote_id")->references("id")->on("centrevotes")->onDelete("cascade");
            $table->unsignedBigInteger("arrondissement_id")->nullable();
            $table->foreign("arrondissement_id")->references("id")->on("arrondissements");
            $table->unsignedBigInteger("commoudept_id");
            $table->foreign("commoudept_id")->references("id")->on("commoudepts");
            $table->unsignedBigInteger("province_id");
            $table->foreign("province_id")->references("id")->on("provinces")->onDelete("cascade");
            $table->unsignedBigInteger("siege_id")->nullable();
            $table->foreign("siege_id")->references("id")->on("sieges")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elects');
    }
};
