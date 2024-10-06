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
        // Define the new permissions
        $newPermissions = json_encode([
            "manage_whatsapp",
            "manage_telegram",
            "manage_ai_writer",
            "manage_team",
            "manage_chat",
            "manage_campaigns",
            "manage_ticket",
            "manage_setting",
            "manage_widget",
            "manage_template",
            "manage_flow"
        ]);

        // Update the permissions for the role with slug 'Client-staff' in the roles table
        DB::table('users')
            ->where('user_type', '=','client-staff')
            ->where('is_primary', 1)
            ->update(['permissions' => $newPermissions]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Define the old permissions
        $oldPermissions = json_encode([
            "manage_whatsapp",
            "manage_telegram",
            "manage_ai_writer",
            "manage_team",
            "manage_chat",
            "manage_campaigns",
            "manage_ticket",
            "manage_setting"
        ]);

        // Revert the permissions for the role with slug 'Client-staff' in the roles table
        DB::table('users')
            ->where('user_type', '=','client-staff')
            ->where('is_primary', 1)
            ->update(['permissions' => $oldPermissions]);
    }
};
