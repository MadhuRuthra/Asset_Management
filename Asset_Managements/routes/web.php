<?php

// Controllers

use App\Http\Controllers\Add_Asset_Controller;
use App\Http\Controllers\AssetCreation_Controller;
use App\Http\Controllers\AssetEntry_Controller;
use App\Http\Controllers\AssetList_Controller;
use App\Http\Controllers\AssetManagerEntry_Controller;
use App\Http\Controllers\Auth\Change_Password_Controller;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\CreateOS_Controller;
use App\Http\Controllers\Dashboard_Controller;
use App\Http\Controllers\EditAsset_Controller;
use App\Http\Controllers\EditCredentials_Controller;
use App\Http\Controllers\EntryList_Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Security\RolePermission;
use App\Http\Controllers\Security\RoleController;
use App\Http\Controllers\Security\PermissionController;
use App\Http\Controllers\SystemCredentials_Controller;
use App\Http\Controllers\SystemCredentialsList_Controller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
// Packages
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

Route::get('/storage', function () {
    Artisan::call('storage:link');
});


//Landing-Pages Routes
Route::group(['prefix' => 'landing-pages'], function() {
Route::get('index',[HomeController::class, 'landing_index'])->name('landing-pages.index');
Route::get('blog',[HomeController::class, 'landing_blog'])->name('landing-pages.blog');
Route::get('blog-detail',[HomeController::class, 'landing_blog_detail'])->name('landing-pages.blog-detail');
Route::get('about',[HomeController::class, 'landing_about'])->name('landing-pages.about');
Route::get('contact',[HomeController::class, 'landing_contact'])->name('landing-pages.contact');
Route::get('ecommerce',[HomeController::class, 'landing_ecommerce'])->name('landing-pages.ecommerce');
Route::get('faq',[HomeController::class, 'landing_faq'])->name('landing-pages.faq');
Route::get('feature',[HomeController::class, 'landing_feature'])->name('landing-pages.feature');
Route::get('pricing',[HomeController::class, 'landing_pricing'])->name('landing-pages.pricing');
Route::get('saas',[HomeController::class, 'landing_saas'])->name('landing-pages.saas');
Route::get('shop',[HomeController::class, 'landing_shop'])->name('landing-pages.shop');
Route::get('shop-detail',[HomeController::class, 'landing_shop_detail'])->name('landing-pages.shop-detail');
Route::get('software',[HomeController::class, 'landing_software'])->name('landing-pages.software');
Route::get('startup',[HomeController::class, 'landing_startup'])->name('landing-pages.startup');
});


//UI Pages Routs
Route::get('/uisheet', [HomeController::class, 'uisheet'])->middleware(['check.session', 'check.active.session'])->name('uisheet');

// In web.php or api.php
Route::post('/assets-by-type', [AssetEntry_Controller::class, 'getAssetsByType'])->middleware(['check.session', 'check.active.session'])->name('assets.by.type');

Route::get('/asset_entry', [AssetEntry_Controller::class, 'AssetEntry'])->middleware(['check.session', 'check.active.session'])->name('asset_entry');

Route::get('/asset_manager_entry', [AssetManagerEntry_Controller::class, 'AssetManagerEntry'])->middleware(['check.session', 'check.active.session'])->name('asset_manager_entry');

Route::get('/asset_list', [AssetList_Controller::class, 'AssetList'])->middleware(['check.session', 'check.active.session'])->name('asset_list');

Route::get('/entry_list', [EntryList_Controller::class, 'EntryList'])->middleware(['check.session', 'check.active.session'])->name('entry_list');

Route::get('/asset_creation', [AssetCreation_Controller::class, 'AssetCreation'])->middleware(['check.session', 'check.active.session'])->name('asset_creation');

Route::post('/savenewasset', [AssetCreation_Controller::class, 'SaveAsset'])->middleware(['check.session', 'check.active.session'])->name('savenewasset');

Route::post('/savenewentry', [AssetEntry_Controller::class, 'NewAssetEntry'])->middleware(['check.session', 'check.active.session'])->name('savenewentry');

Route::post('/savemanagerentry', [AssetManagerEntry_Controller::class, 'SaveManagerEntry'])->middleware(['check.session', 'check.active.session'])->name('savemanagerentry');

Route::get('/edit_asset', [EditAsset_Controller::class, 'EditAsset'])->middleware(['check.session', 'check.active.session'])->name('edit_asset');

Route::get('/edit_asset/{asset_master_id}', [EditAsset_Controller::class, 'EditAssetData'])->middleware(['check.session', 'check.active.session'])->name('edit_asset');

Route::get('/add_asset', [Add_Asset_Controller::class, 'AddAsset'])->middleware(['check.session', 'check.active.session'])->name('add_asset');

Route::get('/add_asset/{asset_master_id}', [Add_Asset_Controller::class, 'AddAssetData'])->middleware(['check.session', 'check.active.session'])->name('add_asset');

Route::post('/save_asset', [Add_Asset_Controller::class, 'SaveAssetData'])->middleware(['check.session', 'check.active.session'])->name('save_asset');

Route::post('/edited_save_asset', [EditAsset_Controller::class, 'SaveEditAssetData'])->middleware(['check.session', 'check.active.session'])->name('edited_save_asset');

Route::post('/delete_asset_data', [AssetList_Controller::class, 'DeleteAssetData'])->middleware(['check.session', 'check.active.session'])->name('delete_asset_data');

Route::post('/delete_assetentry_data', [EntryList_Controller::class, 'DeleteAssetEntryData'])->middleware(['check.session', 'check.active.session'])->name('delete_assetentry_data');


Route::get('/system_credentials', [SystemCredentials_Controller::class, 'SysCredential'])->middleware(['check.session', 'check.active.session'])->name('system_credentials');

Route::get('/system_credentials_list', [SystemCredentialsList_Controller::class, 'SysCredentialList'])->middleware(['check.session', 'check.active.session'])->name('system_credentials_list');

Route::get('/create_os', [CreateOS_Controller::class, 'CreateOS'])->middleware(['check.session', 'check.active.session'])->name('create_os');

Route::post('/save_os', [CreateOS_Controller::class, 'SaveOS'])->middleware(['check.session', 'check.active.session'])->name('save_os');

Route::post('/savesystemcredentials', [SystemCredentials_Controller::class, 'SaveSysCredential'])->middleware(['check.session', 'check.active.session'])->name('savesystemcredentials');

Route::get('/dashboard', [Dashboard_Controller::class, 'DashboardDisplay'])->middleware(['check.session', 'check.active.session'])->name('dashboard');

Route::get('/edit_credentials', [EditCredentials_Controller::class, 'EditCredentials'])->middleware(['check.session', 'check.active.session'])->name('edit_credentials');

Route::get('/edit_credentials/{credential_id}/{serial_number}', [EditCredentials_Controller::class, 'EditCredentialsData'])->middleware(['check.session', 'check.active.session'])->name('edit_credentials');


Route::post('/edited_save_credentials', [EditCredentials_Controller::class, 'SaveEditCredentials'])->middleware(['check.session', 'check.active.session'])->name('edited_save_credentials');

Route::post('/delete_credentials_data', [SystemCredentialsList_Controller::class, 'DeleteCredentials'])->middleware(['check.session', 'check.active.session'])->name('delete_credentials_data');

Route::post('/generate_serial_no', [AssetEntry_Controller::class, 'GenerateSerialNo'])->middleware(['check.session', 'check.active.session'])->name('generate_serial_no');

Route::post('/reset_password_check', [PasswordResetLinkController::class, 'ResetPasswordCheck'])->name('reset_password_check');

Route::get('/changepassword', [Change_Password_Controller::class, 'changepassword'])->name('changepassword');

Route::get('/auth/forgetpassword', [VerifyEmailController::class, 'forgetPassword'])->name('forgetpassword');

Route::post('/forgetpasswordsave', [VerifyEmailController::class, 'ForgetPasswordSave'])->name('forgetpasswordsave');

Route::post('/changepasswordsave', [Change_Password_Controller::class, 'ChangePasswordSave'])->name('changepasswordsave');

Route::post('/validate-old-password', [Change_Password_Controller::class, 'validateOldPassword']);

Route::post('/auth/send-otp', [PasswordResetLinkController::class, 'sendOTP']);

Route::get('/', function () {
    return  redirect('/public/login');
});


Route::group(['middleware' => 'auth'], function () {
    // Permission Module
    Route::get('/role-permission',[RolePermission::class, 'index'])->name('role.permission.list');
    Route::resource('permission',PermissionController::class);
    Route::resource('role', RoleController::class);

    // Dashboard Routes
    Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['check.session', 'check.active.session'])->name('dashboard');

    // Users Module
    Route::resource('users', UserController::class);
}); 

//App Details Page => 'Dashboard'], function() {
Route::group(['prefix' => 'menu-style'], function() {
    //MenuStyle Page Routs
    Route::get('horizontal', [HomeController::class, 'horizontal'])->name('menu-style.horizontal');
    Route::get('dual-horizontal', [HomeController::class, 'dualhorizontal'])->name('menu-style.dualhorizontal');
    Route::get('dual-compact', [HomeController::class, 'dualcompact'])->name('menu-style.dualcompact');
    Route::get('boxed', [HomeController::class, 'boxed'])->name('menu-style.boxed');
    Route::get('boxed-fancy', [HomeController::class, 'boxedfancy'])->name('menu-style.boxedfancy');
});

//App Details Page => 'special-pages'], function() {
Route::group(['prefix' => 'special-pages'], function() {
    //Example Page Routs
    Route::get('billing', [HomeController::class, 'billing'])->name('special-pages.billing');
    Route::get('calender', [HomeController::class, 'calender'])->name('special-pages.calender');
    Route::get('kanban', [HomeController::class, 'kanban'])->name('special-pages.kanban');
    Route::get('pricing', [HomeController::class, 'pricing'])->name('special-pages.pricing');
    Route::get('rtl-support', [HomeController::class, 'rtlsupport'])->name('special-pages.rtlsupport');
    Route::get('timeline', [HomeController::class, 'timeline'])->name('special-pages.timeline');
});

//Widget Routs
Route::group(['prefix' => 'widget'], function() {
    Route::get('widget-basic', [HomeController::class, 'widgetbasic'])->name('widget.widgetbasic');
    Route::get('widget-chart', [HomeController::class, 'widgetchart'])->name('widget.widgetchart');
    Route::get('widget-card', [HomeController::class, 'widgetcard'])->name('widget.widgetcard');
});

//Maps Routs
Route::group(['prefix' => 'maps'], function() {
    Route::get('google', [HomeController::class, 'google'])->name('maps.google');
    Route::get('vector', [HomeController::class, 'vector'])->name('maps.vector');
});

//Auth pages Routs
Route::group(['prefix' => 'auth'], function() {
    Route::get('signin', [HomeController::class, 'signin'])->name('auth.signin');
    Route::get('signup', [HomeController::class, 'signup'])->name('auth.signup');
    // Route::get('confirmmail', [HomeController::class, 'confirmmail'])->name('auth.confirmmail');
    Route::get('lockscreen', [HomeController::class, 'lockscreen'])->name('auth.lockscreen');
    Route::get('recoverpw', [HomeController::class, 'recoverpw'])->name('auth.recoverpw');
    Route::get('userprivacysetting', [HomeController::class, 'userprivacysetting'])->name('auth.userprivacysetting');
});

//Error Page Route
Route::group(['prefix' => 'errors'], function() {
    Route::get('error404', [HomeController::class, 'error404'])->name('errors.error404');
    Route::get('error500', [HomeController::class, 'error500'])->name('errors.error500');
    Route::get('maintenance', [HomeController::class, 'maintenance'])->name('errors.maintenance');
});


//Forms Pages Routs
Route::group(['prefix' => 'forms'], function() {
    Route::get('element', [HomeController::class, 'element'])->name('forms.element');
    Route::get('wizard', [HomeController::class, 'wizard'])->name('forms.wizard');
    Route::get('validation', [HomeController::class, 'validation'])->name('forms.validation');
});


//Table Page Routs
Route::group(['prefix' => 'table'], function() {
    Route::get('bootstraptable', [HomeController::class, 'bootstraptable'])->name('table.bootstraptable');
    Route::get('datatable', [HomeController::class, 'datatable'])->name('table.datatable');
});

//Icons Page Routs
Route::group(['prefix' => 'icons'], function() {
    Route::get('solid', [HomeController::class, 'solid'])->name('icons.solid');
    Route::get('outline', [HomeController::class, 'outline'])->name('icons.outline');
    Route::get('dualtone', [HomeController::class, 'dualtone'])->name('icons.dualtone');
    Route::get('colored', [HomeController::class, 'colored'])->name('icons.colored');
});
//Extra Page Routs
Route::get('privacy-policy', [HomeController::class, 'privacypolicy'])->name('pages.privacy-policy');
Route::get('terms-of-use', [HomeController::class, 'termsofuse'])->name('pages.term-of-use');
