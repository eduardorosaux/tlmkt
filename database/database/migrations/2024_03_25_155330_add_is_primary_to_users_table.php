<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_primary')->default(false)->after('status');
        });
        // Update is_primary for the first created user of each client
        DB::statement("
         UPDATE users u
         JOIN (
             SELECT MIN(id) as min_id, client_id
             FROM users
             GROUP BY client_id
         ) first_users ON u.id = first_users.min_id
         SET u.is_primary = 1
     ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_primary');
        });
    }
};
