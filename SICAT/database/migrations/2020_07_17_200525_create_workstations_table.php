<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkstationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workstations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->foreignId('locale_id')->constrained('locales');
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
        Schema::table('workstations', function (Blueprint $table) {
            $table->dropForeign(['locale_id']);
            if (Schema::hasColumn('workstations', 'status_id')) {
                $table->dropForeign(['status_id']);
            }
        });
        Schema::dropIfExists('workstations');
    }
}
