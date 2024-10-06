<?php

namespace App\Http\Controllers\Client;

use App\DataTables\SegmentsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\SegmentsRequest;
use App\Repositories\Client\SegmentsRepository;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SegmentsController extends Controller
{
    protected $segmentsRepo;

    public function __construct(SegmentsRepository $segmentsRepo)
    {
        $this->segmentsRepo = $segmentsRepo;
    }

    public function index(SegmentsDataTable $segmentsDataTable)
    {
        return $segmentsDataTable->render('backend.client.whatsapp.segments.index');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status' => 'danger',
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }

        $request->validate([
            'title' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $requestData = array_merge($request->all(), ['client_id' => Auth::user()->client_id]);
            $this->segmentsRepo->store($requestData);
            DB::commit();
            Toastr::success(__('create_successful'));

            return response()->json(['success' => __('create_successful')]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => 'Something went wrong, please try again']);
        }
    }

    public function edit($id): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        try {
            $segments = $this->segmentsRepo->find($id);
            $data     = [
                'segments' => $segments,
            ];

            return view('backend.client.whatsapp.segments.edit', $data);
        } catch (Exception $e) {
            Toastr::error('Something went wrong, please try again');

            return back();
        }
    }

    public function update(SegmentsRequest $request, $id)
    {
        if (isDemoMode()) {
            Toastr::error(__('this_function_is_disabled_in_demo_server'));

            return back();
        }
        try {
            $this->segmentsRepo->update($request->all(), $id);
            Toastr::success(__('update_successful'));

            return redirect()->route('client.segments.index');
        } catch (Exception $e) {
            Toastr::error('Something went wrong, please try again');

            return back()->withInput();
        }
    }

    public function statusChange(Request $request): \Illuminate\Http\JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status'  => 'danger',
                'message' => __('this_function_is_disabled_in_demo_server'),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
        try {
            $this->segmentsRepo->statusChange($request->all());
            $data = [
                'status'  => 'success',
                'message' => __('update_successful'),
                'title'   => 'success',
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            $data = [
                'status'  => 'danger',
                'message' => 'Something went wrong, please try again',
                'title'   => __('error'),
            ];

            return response()->json($data);
        }
    }
}
