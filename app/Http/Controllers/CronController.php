<?php

namespace App\Http\Controllers;

use App\Repositories\Client\WaCampaignRepository;
use App\Repositories\SettingRepository;
use App\Repositories\Webhook\WhatsappRepository;
use App\Traits\WhatsAppTrait;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class CronController extends Controller
{
    use WhatsAppTrait;
    protected $campaign;
    protected $whatsappRepo;
    protected $settingRepo;

public function __construct(WaCampaignRepository $campaign, WhatsappRepository $whatsappRepo,SettingRepository $settingRepo)
{
    $this->campaign             = $campaign;
    $this->whatsappRepo         = $whatsappRepo;
    $this->settingRepo          = $settingRepo;
}
    public function index($key, Request $request)
    {
        if($key !== setting('cron_key')):
            dd(__('invalid_cron_key'));
        endif;
        try {
            // send whatsapp message
            $this->campaign->sendScheduleMessage($request);
            $request['last_cron_run_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $this->settingRepo->update($request);
            Artisan::call('all:clear');
            echo __('run_successfully');
        }catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again', 'Error!');
            return back();
        }
    }

    public function manual_run(Request $request)
    {
        try {
            $this->campaign->sendScheduleMessage($request);
            $request['last_cron_run_at'] = Carbon::now()->format('Y-m-d H:i:s');
            $this->settingRepo->update($request);
            Artisan::call('all:clear');
            Toastr::success(__('run_successfully'));
            return back();
        }catch (\Exception $e) {
            Toastr::error('something_went_wrong_please_try_again', 'Error!');
            return back();
        }
    }
   public function AddonsMigrate()
    {
        try {
            $addonDirectory = base_path('app/Addons');
            if (is_dir($addonDirectory)) {
                $addonDirectories = array_diff(scandir($addonDirectory), ['.', '..']);
                foreach ($addonDirectories as $addonDirectoryName) {
                    Artisan::call('migrate', [
                        '--path' => "app/Addons/{$addonDirectoryName}/migrations",
                        '--force' => true,
                    ]);
                }
            } else {
                dd("Addon directory not found: $addonDirectory");
            }
            Artisan::call('all:clear');
            Toastr::success(__('cache_cleared_successfully'));
            return back();
        } catch (\Exception $e) {
            if (config('app.debug')) {
                dd($e->getMessage());            
            }
            Toastr::error('something_went_wrong_please_try_again', 'Error!');
            return back();
        }
    }
}
