<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('amount');
            $table->enum('availability', ['true', 'false'])->default('true');
            $table->foreignId('type_id')->constrained('types');
            $table->foreignId('status_id')->constrained('status');
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
        Schema::create('items', function (Blueprint $table) {
            $table->dropForeign(['type_id']);
            $table->dropForeign(['status_id']);
        });
        Schema::dropIfExists('items');
    }
}
