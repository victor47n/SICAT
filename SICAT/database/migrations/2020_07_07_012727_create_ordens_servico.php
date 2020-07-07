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
            $table->string("os_descricao", 150);
            $table->string("os_problema", 255);
            $table->timestamp("os_data_agendado")->useCurrent();
            $table->integer("os_status");
            $table->integer("os_local");
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
