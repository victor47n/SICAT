<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_services', function (Blueprint $table) {
            $table->id();
            $table->string('problem_type', 100);
            $table->string('problem', 100);
            $table->dateTime('realized_date');
            $table->text('solution_problem');
            $table->foreignId('designated_employee');
            $table->foreignId('solver_employee');
            $table->foreignId('locale_id')->constrained('locales');
            $table->foreignId('workstation_id')->constrained('workstations');
            $table->foreignId('status_id')->constrained('status');
            $table->foreign('designated_employee')->references('id')->on('users');
            $table->foreign('solver_employee')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_services');
    }
}
