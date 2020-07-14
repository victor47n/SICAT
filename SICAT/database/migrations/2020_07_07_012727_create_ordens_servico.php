<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdensServico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordens_servico', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("description", 150);
            $table->string("problem", 255);
            $table->timestamp("scheduled")->useCurrent();
            $table->integer("status");
            $table->integer("place");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Ordens_Servico');
    }
}
