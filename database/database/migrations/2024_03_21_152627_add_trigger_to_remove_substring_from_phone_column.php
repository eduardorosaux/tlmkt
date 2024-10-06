<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddTriggerToRemoveSubstringFromPhoneColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // DB::unprepared('
        //     CREATE TRIGGER before_insert_contacts
        //     BEFORE INSERT ON contacts
        //     FOR EACH ROW
        //     BEGIN
        //         SET NEW.phone = REPLACE(NEW.phone, " ", "");
        //     END;
        // ');
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::unprepared('DROP TRIGGER IF EXISTS before_insert_contacts');
    }
}
