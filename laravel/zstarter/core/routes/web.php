<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\ArticleController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Panel\UserAddresController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Admin\ConstantManagement\WorldController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\UtilityController; 
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
Route::get('/qb', function () {
    return dd(ctype_upper('neha'[0]));
    return UserRole(3)['name'];
    return view('backend.admin.maintanance.index');
    $mailcontent_data = App\Models\MailSmsTemplate::where('code','=',"otp-send")->first();
   $arr=[
       '{OTP}'=>"1234",
       '{reason}'=>"MYID",
       '{app_name}'=>"Defenzelite Outsourcing",
       '{date_time}'=>\Carbon\Carbon::now()->format('d M Y,h:i'),
    ];
    // return short_code_parser($mailcontent_data->body,$arr);
    $msg = DynamicMailTemplateFormatter($mailcontent_data->body,$mailcontent_data->variables,$arr);
    return sendSms("8823874387",$msg,$mailcontent_data->footer);
//   return  createOrder(1, [], "offline", 0, 0,  null, null);
    return  view('demotest');
    return trans('Profile');
    $mailcontent_data = App\Models\MailSmsTemplate::where('code','=',"Welcome")->first();
    $arr=[
        '{name}'=>"parul",
        '{id}'=>"MYID",
    ];
    // return asset('storage/backend/logos/white-logo-662.png');
  return  customMail("parul","parulsagrawal@gmail.com",$mailcontent_data,$arr,null ,null ,$action_btn = null ,asset('storage/backend/logos/white-logo-662.png') ,"white-logo-662.png" ,$attachment_mime = null);
    // \Artisan::call('migrate');
    return "s";
    return trans('greeting', ['name' => 'Parul','val'=>200]) ;
    return dd(ResourceBundle::getLocales(''));
    // return toLocalTime(\Carbon\Carbon::now());
    return 's';
});

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    Route::group(['prefix' => 'utility', ], function (){
        Route::get('clear-column/{modal_name}/{column_name}/{id}',[UtilityController::class,'clearColumn']);
        });
    
       



    // Frontend Route Start-------------------------------------------------------------------------------------
        Route::get('/', [HomeController::class,'index'])->name('index');
        Route::get('/about', [HomeController::class,'about'])->name('about');
        Route::get('page-error', [HomeController::class,'notFound'])->name('error.index');
        Route::get('maintanance', [HomeController::class,'maintanance'])->name('maintanance.index');
        Route::post('/newsletter/store', [HomeController::class,'storeNewsletter'])->name('newsletter.store');
        // Articles
        Route::get('/blogs', [ArticleController::class,'index'])->name('article.index');
        Route::get('/blog/{slug}', [ArticleController::class,'show'])->name('article.show');
        // Contact
        Route::get('/contact', [ContactController::class,'index'])->name('contact');
        Route::post('/contact/store', [ContactController::class,'store'])->name('contact.store');
        
        Route::get('/page', function () {
            return view('frontend.index');
        });

        // Customer Routes
        Route::group(['middleware' => ['auth'],'namespace' => '/customer', 'prefix' => 'customer', 'as' => 'customer.'], function () {
            Route::get('/home', [CustomerController::class,'account'])->name('profile');
            Route::get('/notifications', [CustomerController::class,'notification'])->name('notification');
            Route::get('/setting', [CustomerController::class,'setting'])->name('setting');
            Route::get('/wallet', [WalletController::class,'index'])->name('wallet');
            Route::get('/address', [CustomerController::class,'address'])->name('address');
            Route::post('/address', [UserAddresController::class,'store'])->name('address.store');
            Route::post('/info-update/{id}', [CustomerController::class,'updateAccountInfo'])->name('update.info');
            Route::post('/verify-ekyc', [CustomerController::class,'ekycVerify'])->name('ekyc.store');
            Route::get('/address/delete/{id}', [UserAddresController::class,'destroy'])->name('address.destroy');
            Route::post('/address/update/', [UserAddresController::class,'update'])->name('address.update');
            Route::get('/payout', [WalletController::class,'payout'])->name('payout.request.index');
            Route::post('/payout-store', [WalletController::class,'payoutStore'])->name('payout.store');
            Route::post('/wallet/logs', [WalletController::class,'storeWalletLog'])->name('wallet-log.store');
            Route::group(['middleware' => ['web'],'namespace' => '/order', 'prefix' => 'order', 'as' => 'order.'], function () {
                Route::get('/', [CustomerController::class,'orderIndex'])->name('index');
                Route::get('/invoice/{o_id}', [CustomerController::class,'invoice'])->name('invoice');
            });
        });


        Route::get('login', [LoginController::class,'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class,'login']);
        Route::get('register', [RegisterController::class,'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class,'register']);
        
        // Socialite Routes
        Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
        Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);

        //Email Verification Routes
        Route::get('/email/verify', function () {
            return view('auth.verify');
        })->middleware('auth')->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
            $request->fulfill();
            return redirect('panel/dashboard');
        })->middleware(['auth', 'signed'])->name('verification.verify');
        Route::post('/email/verification-notification', function (Request $request) {
            $request->user()->sendEmailVerificationNotification();
        
            return back()->with('message', 'Verification link sent!');
        })->middleware(['auth', 'throttle:6,1'])->name('verification.resend');


        //SMS Verification routes
        Route::get('/sms/verify', function () {
            return view('auth.sms-verify');
        })->name('sms.verify');
        Route::post('/sms/verify', [HomeController::class,'smsVerification'])->name('sms.verify');

        //Password Routes
        Route::get('password/forget', function () {
            return view('global.forgot-password');
        })->name('password.forget');
        Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
        Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');
        
        Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::get('paysuccess', [CheckoutController::class, 'razorPaySuccess'])->name('checkout.razorpay');
        
        // Frontend Route END-------------------------------------------------------------------------------------
        
        
        
        Route::group(['middleware' => 'auth'], function () {
            // logout route
            Route::get('/logout', [LoginController::class,'logout']);
        });



    Route::get('get-states', [WorldController::class,'getStates'])->name('world.get-states');
    Route::get('get-cities', [WorldController::class,'getCities'])->name('world.get-cities');

Route::get('/offline', function () { return view('vendor/laravelpwa/offline'); });

Route::get('/page/{slug}', [HomeController::class,'page'])->name('page.slug');
//  Routes For Backend only

Route::group([], function () {
    require_once(__DIR__ . '/panel.php');
    require_once(__DIR__ . '/crudgen.php');
});
Route::get('/sms/verify', function () {
    return view('global.500');
});