<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnReceiverIdAndReturnDateNullableToBorrowedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('borrowed_items', function (Blueprint $table) {
            $table->foreignId('receiver_id')->nullable()->change();
            $table->dateTime('return_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('borrowed_items', function (Blueprint $table) {
            //
        });
    }
}
