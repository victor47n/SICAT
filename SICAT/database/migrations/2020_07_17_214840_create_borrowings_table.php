<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBorrowingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->string('requester', 100);
            $table->string('phone_requester', 15);
            $table->string('email_requester', 100);
            $table->string('office_requester', 50);
            $table->integer('amount');
            $table->dateTime('return_date');
            $table->foreignId('item_id')->constrained('items');
            $table->foreignId('status_id')->constrained('statuses');
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
        Schema::table('borrowings', function (Blueprint $table) {
            if (Schema::hasColumn('borrowing', 'item_id')) {
                $table->dropForeign(['item_id']);
            }
            $table->dropForeign(['status_id']);
        });

        Schema::dropIfExists('borrowings');
    }
}
