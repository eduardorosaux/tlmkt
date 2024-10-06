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
        // Check if 'active_theme' exists in the settings table
        $activeTheme = DB::table('settings')->where('title', 'active_theme')->first();

        // If it doesn't exist, insert a new row with 'active_theme' and value 'default'
        if (!$activeTheme) {
            DB::table('settings')->insert([
                'title' => 'active_theme',
                'value' => 'default',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    public function down()
    {
        // Optionally, you can remove the entry if it was added in the up method
        DB::table('settings')->where('title', 'active_theme')->where('value', 'default')->delete();
    }
};
