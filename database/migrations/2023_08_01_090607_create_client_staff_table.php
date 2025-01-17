<?php

use App\Models\ClientStaff;
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
        if (!Schema::hasTable('client_staff')) {
            Schema::create('client_staff', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
                $table->unsignedBigInteger('client_id')->nullable();
                $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');
                $table->string('slug')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_staff');
    }
};
