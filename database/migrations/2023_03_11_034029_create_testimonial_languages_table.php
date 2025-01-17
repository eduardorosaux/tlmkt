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
        if (!Schema::hasTable('testimonial_languages')) {
            Schema::create('testimonial_languages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('testimonial_id');
                $table->string('lang');
                $table->string('name');
                $table->string('title');
                $table->string('designation');
                $table->text('description')->nullable();
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
        Schema::dropIfExists('testimonial_langugaes');
    }
};
