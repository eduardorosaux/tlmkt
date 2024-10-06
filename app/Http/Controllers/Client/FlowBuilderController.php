<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\FlowBuilderFile;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;

class FlowBuilderController extends Controller
{
    use ImageTrait;

    public function uploadFile(Request $request): \Illuminate\Http\JsonResponse
    {
        $file_name = time().'.'.$request->file('file')->getClientOriginalExtension();
        $request->file('file')->move(public_path('client/flow_builder'), $file_name);
        $flow      = FlowBuilderFile::create([
            'file'               => 'client/flow_builder/'.$file_name,
            'flow_template_id'   => $request->id,
            'flow_template_type' => $request->type,
        ]);

        return response()->json([
            'success'     => 'File uploaded successfully',
            'file_object' => [
                'id'   => $flow->flow_template_id,
                'file' => static_asset($flow->file),
            ],
        ]);
    }
}
