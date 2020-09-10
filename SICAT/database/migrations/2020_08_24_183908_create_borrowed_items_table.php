<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowed_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings');
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('lender_id');
            $table->foreignId('receiver_id');
            $table->foreignId('status_id')->constrained('statuses');
            $table->dateTime('return_date');
            $table->foreign('lender_id')->references('id')->on('users');
            $table->foreign('receiver_id')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
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
            $table->dropForeign(['borrowing_id']);
            $table->dropForeign(['item_id']);
            $table->dropForeign(['lender_id']);
            $table->dropForeign(['receiver_id']);
        });
        Schema::dropIfExists('borrowed_items');
    }
}
