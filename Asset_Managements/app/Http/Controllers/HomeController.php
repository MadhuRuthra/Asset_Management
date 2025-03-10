<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    /*
     * Dashboard Pages Routs
     */
    public function index(Request $request)
    {

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . 'Dahboard Page Access');

        $total = DB::table('asset_managers')->where('assigned_status', '=', 'Y')->count();

        $total_value = array(
            'total' => $total,
        );

        $data = DB::table('asset_masters')
        ->leftJoin('asset_managers', 'asset_managers.asset_master_id', '=', 'asset_masters.asset_master_id')
        ->select(
            'asset_masters.asset_master_id',
            'asset_masters.asset_name',
            'asset_managers.assigned_status',
            DB::raw('GROUP_CONCAT(asset_managers.asset_serial_no) as asset_serial_nos'),
            DB::raw('count(asset_managers.asset_manager_id) as asset_managers_count')
        )
        ->where('assigned_status', '=', 'Y')
        ->groupBy('asset_masters.asset_master_id', 'asset_masters.asset_name','asset_managers.assigned_status')
        ->get();


        // echo "".json_encode($total_value).""; exit;

        Log::channel('daily')->info(now() . '-' . Auth::user()->name . json_encode($data));

        $assets = ['chart', 'animation', $data, $total_value];
        return view('dashboards.dashboard', compact('assets'));
    }

    /*
     * Menu Style Routs
     */
    public function horizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.horizontal',compact('assets'));
    }
    public function dualhorizontal(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-horizontal',compact('assets'));
    }
    public function dualcompact(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.dual-compact',compact('assets'));
    }
    public function boxed(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed',compact('assets'));
    }
    public function boxedfancy(Request $request)
    {
        $assets = ['chart', 'animation'];
        return view('menu-style.boxed-fancy',compact('assets'));
    }

    /*
     * Pages Routs
     */
    public function billing(Request $request)
    {
        return view('special-pages.billing');
    }

    public function calender(Request $request)
    {
        $assets = ['calender'];
        return view('special-pages.calender',compact('assets'));
    }

    public function kanban(Request $request)
    {
        return view('special-pages.kanban');
    }

    public function pricing(Request $request)
    {
        return view('special-pages.pricing');
    }

    public function rtlsupport(Request $request)
    {
        return view('special-pages.rtl-support');
    }

    public function timeline(Request $request)
    {
        return view('special-pages.timeline');
    }


    /*
     * Widget Routs
     */
    public function widgetbasic(Request $request)
    {
        return view('widget.widget-basic');
    }
    public function widgetchart(Request $request)
    {
        $assets = ['chart'];
        return view('widget.widget-chart', compact('assets'));
    }
    public function widgetcard(Request $request)
    {
        return view('widget.widget-card');
    }


    /*
     * Maps Routs
     */
    public function google(Request $request)
    {
        return view('maps.google');
    }
    public function vector(Request $request)
    {
        return view('maps.vector');
    }

    /*
     * Auth Routs
     */
    public function signin(Request $request)
    {
        return view('auth.login');
    }
    public function signup(Request $request)
    {
        return view('auth.register');
    }
    public function confirmmail(Request $request)
    {
        return view('auth.confirm-mail');
    }
    public function lockscreen(Request $request)
    {
        return view('auth.lockscreen');
    }
    public function recoverpw(Request $request)
    {
        return view('auth.recoverpw');
    }
    public function userprivacysetting(Request $request)
    {
        return view('auth.user-privacy-setting');
    }

    /*
     * Error Page Routs
     */

    public function error404(Request $request)
    {
        return view('errors.error404');
    }

    public function error500(Request $request)
    {
        return view('errors.error500');
    }
    
    public function maintenance(Request $request)
    {
        return view('errors.maintenance');
    }

    /*
     * uisheet Page Routs
     */
    public function uisheet(Request $request)
    {
        return view('uisheet');
    }

    /*
     * Form Page Routs
     */
    public function element(Request $request)
    {
        return view('forms.element');
    }

    public function wizard(Request $request)
    {
        return view('forms.wizard');
    }

    public function validation(Request $request)
    {
        return view('forms.validation');
    }

     /*
     * Table Page Routs
     */
    public function bootstraptable(Request $request)
    {
        return view('table.bootstraptable');
    }

    public function datatable(Request $request)
    {
        return view('table.datatable');
    }

    /*
     * Icons Page Routs
     */

    public function solid(Request $request)
    {
        return view('icons.solid');
    }

    public function outline(Request $request)
    {
        return view('icons.outline');
    }

    public function dualtone(Request $request)
    {
        return view('icons.dualtone');
    }

    public function colored(Request $request)
    {
        return view('icons.colored');
    }

    /*
     * Extra Page Routs
     */
    public function privacypolicy(Request $request)
    {
        return view('privacy-policy');
    }
    public function termsofuse(Request $request)
    {
        return view('terms-of-use');
    }


    /*
    * Landing Page Routs
    */
    public function landing_index(Request $request)
    {
        return view('landing-pages.pages.index');
    }
    public function landing_blog(Request $request)
    {
        return view('landing-pages.pages.blog');
    }
    public function landing_about(Request $request)
    {
        return view('landing-pages.pages.about');
    }
    public function landing_blog_detail(Request $request)
    {
        return view('landing-pages.pages.blog-detail');
    }
    public function landing_contact(Request $request)
    {
        return view('landing-pages.pages.contact-us');
    }
    public function landing_ecommerce(Request $request)
    {
        return view('landing-pages.pages.ecommerce-landing-page');
    }
    public function landing_faq(Request $request)
    {
        return view('landing-pages.pages.faq');
    }
    public function landing_feature(Request $request)
    {
        return view('landing-pages.pages.feature');
    }
    public function landing_pricing(Request $request)
    {
        return view('landing-pages.pages.pricing');
    }
    public function landing_saas(Request $request)
    {
        return view('landing-pages.pages.saas-marketing-landing-page');
    }
    public function landing_shop(Request $request)
    {
        return view('landing-pages.pages.shop');
    }
    public function landing_shop_detail(Request $request)
    {
        return view('landing-pages.pages.shop_detail');
    }
    public function landing_software(Request $request)
    {
        return view('landing-pages.pages.software-landing-page');
    }
    public function landing_startup(Request $request)
    {
        return view('landing-pages.pages.startup-landing-page');
    }
}
