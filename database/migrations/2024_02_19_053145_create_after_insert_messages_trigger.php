<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
class CreateAfterInsertMessagesTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    //     DB::unprepared('
    //     SET GLOBAL log_bin_trust_function_creators = 1;
    //     CREATE TRIGGER after_insert_messages AFTER INSERT ON messages FOR EACH ROW
    //     BEGIN
    //         UPDATE campaigns
    //         SET total_contact = total_contact + 1
    //         WHERE id = NEW.campaign_id;
    //     END
    // ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_insert_messages');
    }
}
