<?php

use App\Enums\StatusEnum;
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
        Schema::table('campaigns', function (Blueprint $table) {
            //  $table->enum('status', [
            //     StatusEnum::ACTIVE->value,
            //     StatusEnum::INACTIVE->value,
            //     StatusEnum::CANCELED->value,
            //     StatusEnum::COMPLETE->value,
            //     StatusEnum::HOLD->value,
            //     StatusEnum::QUEUED->value,
            //     StatusEnum::STOP->value,
            // ])->default(StatusEnum::ACTIVE->value);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaigns', function (Blueprint $table) {
            // $table->dropColumn('status');
        });
    }
};
