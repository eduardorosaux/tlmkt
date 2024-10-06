<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_settings', function (Blueprint $table) {
            // Change column type to VARCHAR and add unique constraint
            // $table->string('access_token')->unique()->change();
            // $table->index(['access_token'], 'client_settings_access_token_unique')->length(300);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_settings', function (Blueprint $table) {
            // Drop unique constraint and revert column type to its original state
            // $table->dropUnique('client_settings_access_token_unique');
            // $table->text('access_token')->change();
        });
    }
};
