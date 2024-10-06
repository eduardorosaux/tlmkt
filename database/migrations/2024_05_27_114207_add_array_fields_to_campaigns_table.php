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
        // Add new columns to store array data
        Schema::table('campaigns', function (Blueprint $table) {
            $table->json('contact_list_ids')->nullable();
            $table->json('segment_ids')->nullable();
        });
          // Convert existing integer data to array and update new columns
        //   DB::table('campaigns')->orderBy('id')->chunk(100, function ($campaigns) {
        //     foreach ($campaigns as $campaign) {
        //         $contactListIds = [$campaign->contact_list_id];
        //         $segmentIds = [$campaign->segment_id];

        //         DB::table('campaigns')
        //             ->where('id', $campaign->id)
        //             ->update([
        //                 'contact_list_ids' => json_encode($contactListIds),
        //                 'segment_ids' => json_encode($segmentIds),
        //             ]);
        //     }
        // });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // You can define the down method to revert the changes if needed.
        // However, since you're keeping the original columns, down migration might not be necessary.
    }
};
