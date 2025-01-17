<?php
namespace App\Http\Controllers;
use App\Models\Subscriber;
use App\Traits\RepoResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use App\Repositories\PageRepository;
use App\Repositories\PlanRepository;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Repositories\WebsiteFaqRepository;
use App\Repositories\WebsiteStoryRepository;
use App\Repositories\WebsiteFeatureRepository;
use App\Repositories\WebsiteAdvantageRepository;
use App\Repositories\WebsitePartnerLogoRepository;
use App\Repositories\WebsiteTestimonialRepository;
use App\Repositories\WebsiteUniqueFeatureRepository;

class HomeController extends Controller
{
    use RepoResponse;
    protected $planRepository;

    protected $partnerLogoRepository;

    protected $storyRepository;

    protected $uniqueFeatureRepository;

    protected $featureRepository;

    protected $advantageRepository;

    protected $faqRepository;

    protected $testimonialRepository;

    protected $subscribe;

    public function __construct(
        PlanRepository $planRepository,
        WebsitePartnerLogoRepository $partnerLogoRepository,
        WebsiteStoryRepository $storyRepository,
        WebsiteUniqueFeatureRepository $uniqueFeatureRepository,
        WebsiteFeatureRepository $featureRepository,
        WebsiteAdvantageRepository $advantageRepository,
        WebsiteFaqRepository $faqRepository,
        WebsiteTestimonialRepository $testimonialRepository,
        Subscriber $subscribe)
    {
        $this->planRepository          = $planRepository;
        $this->partnerLogoRepository   = $partnerLogoRepository;
        $this->storyRepository         = $storyRepository;
        $this->uniqueFeatureRepository = $uniqueFeatureRepository;
        $this->featureRepository       = $featureRepository;
        $this->advantageRepository     = $advantageRepository;
        $this->faqRepository           = $faqRepository;
        $this->testimonialRepository   = $testimonialRepository;
        $this->subscribe   = $subscribe;

    }

    public function index(Request $request, PlanRepository $planRepository)
    {

        $languages        = app('languages');
        $lang             = $request->site_lang ? $request->site_lang : App::getLocale();
        $menu_quick_link  = headerFooterMenu('footer_quick_link_menu', $lang);
        $menu_useful_link = headerFooterMenu('footer_useful_link_menu');

        $data             = [
            'plans'             => $this->planRepository->all(),
            'plans2'            => [
                'daily'       => $this->planRepository->activePlans([], 'daily'),
                'weekly'      => $this->planRepository->activePlans([], 'weekly'),
                'monthly'     => $this->planRepository->activePlans([], 'monthly'),
                'quarterly'   => $this->planRepository->activePlans([], 'quarterly'),
                'half_yearly' => $this->planRepository->activePlans([], 'half_yearly'),
                'yearly'      => $this->planRepository->activePlans([], 'yearly'),
            ],
            'partner_logos'     => $this->partnerLogoRepository->all(),
            'stories'           => $this->storyRepository->all(),
            'unique_features'   => $this->uniqueFeatureRepository->all(),
            'features'          => $this->featureRepository->all(),
            'whatsapp_features' => $this->featureRepository->whatsapp(),
            'telegram_features' => $this->featureRepository->telegram(),
            'advantages'        => $this->advantageRepository->all(),
            'faqs'              => $this->faqRepository->all(),
            'testimonials'      => $this->testimonialRepository->all(),
            'menu_quick_links'  => $menu_quick_link,
            'menu_useful_links' => $menu_useful_link,
            'lang'              => $request->lang ?? app()->getLocale(),
            'menu_language'     => headerFooterMenu('header_menu', $lang),
        ];

        return view('website.themes.'.active_theme().'.home', $data);
    }

    public function page(Request $request, $link, PageRepository $pageRepository)
    {
        $page              = $pageRepository->findByLink($link);
        $lang              = $request->lang ?? app()->getLocale();
        $menu_quick_link   = headerFooterMenu('footer_quick_link_menu', $lang);
        $menu_useful_link  = headerFooterMenu('footer_useful_link_menu');
        $data['page_info'] = $pageRepository->getByLang($page->id, $lang);

        $data              = [
            'menu_quick_links'  => $menu_quick_link,
            'menu_useful_links' => $menu_useful_link,
            'lang'              => $request->lang ?? app()->getLocale(),
            'menu_language'     => headerFooterMenu('header_menu', $lang),
            'page_info'         => $pageRepository->getByLang($page->id, $lang),
        ];

        return view('website.themes.'.active_theme().'.page', $data);

        // return view('website.page', $data);
    }

    public function cacheClear()
    {
        try {
            Artisan::call('all:clear');
            Artisan::call('migrate', ['--force' => true]);
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

    public function changeLanguage($locale): \Illuminate\Http\RedirectResponse
    {
        cache()->get('locale');
        app()->setLocale($locale);
        return redirect()->back();
    }


    public function subscribeStore(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:subscribers'],
            ],
            [
                'email.unique' => __('email_already_subscribed'),
            ]
        );
      
        $result = $this->subscribe->subscribeStore($request);
        if ($result->status) {
            return response()->json($result, 200);
        }
        return response()->json($result, 200);

    }




}
