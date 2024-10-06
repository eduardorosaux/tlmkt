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
            "manage_template",
            "manage_widget",
            "manage_flow"
        ]);

        // Update the permissions for the role with slug 'Client-staff'
        DB::table('roles')
            ->where('slug', 'Client-staff')
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

        // Revert the permissions for the role with slug 'Client-staff'
        DB::table('roles')
            ->where('slug', 'Client-staff')
            ->update(['permissions' => $oldPermissions]);
    }
};
