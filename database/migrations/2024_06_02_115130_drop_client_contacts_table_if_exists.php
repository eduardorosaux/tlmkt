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
        // Check if the 'client_contacts' table exists and drop it
        if (Schema::hasTable('client_contacts')) {
            Schema::dropIfExists('client_contacts');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you can recreate the table if needed
        // Schema::create('client_contacts', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('contact_name');
        //     // Add other necessary columns here
        //     $table->timestamps();
        // });
    }
};
