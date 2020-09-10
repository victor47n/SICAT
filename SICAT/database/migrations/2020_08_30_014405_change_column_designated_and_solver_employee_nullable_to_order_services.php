<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnDesignatedAndSolverEmployeeNullableToOrderServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_services', function (Blueprint $table) {
            $table->foreignId('designated_employee')->nullable()->change();
            $table->foreignId('solver_employee')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_services', function (Blueprint $table) {
            //
        });
    }
}
