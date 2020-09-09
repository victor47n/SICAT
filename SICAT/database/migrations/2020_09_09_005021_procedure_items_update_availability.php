<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ProcedureItemsUpdateAvailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            '
                        CREATE PROCEDURE update_availability (IN item_id int)
                        BEGIN
                            DECLARE amount_item INT DEFAULT 0;
                            DECLARE avail varchar(5);

                            SELECT amount INTO amount_item FROM items WHERE id = item_id;
                            SELECT availability INTO avail FROM items WHERE id = item_id;

                            IF (amount_item > 0) and (avail != "true") THEN
                                UPDATE items SET availability = "true" WHERE id = item_id;
                            ELSEIF (amount_item = 0) and (avail != "false") THEN
                                UPDATE items SET availability = "false" WHERE id = item_id;
                            END IF;
                        END'
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE update_availability');
    }
}
