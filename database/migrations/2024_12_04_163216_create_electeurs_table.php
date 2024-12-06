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
        Schema::create('electeurs', function (Blueprint $table) {
            $table->id();
            $table->string("nip_ipn");
            $table->string("nom");
            $table->string("prenom");
            $table->string("date_naiss");
            $table->string("lieu_naiss");
            $table->unsignedBigInteger("centrevote_id")->index();
            $table->foreign("centrevote_id")->references("id")->on("centrevotes")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('electeurs');
    }
};
