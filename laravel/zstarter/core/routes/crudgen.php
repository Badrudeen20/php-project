<?php
use App\Http\Controllers\CrudGenrator\CrudGenController;

Route::group(['middleware' => 'can:manage_dev','prefix' => 'dev/crudgen', 'as' => 'crudgen.'], function () {

    Route::get('/', [CrudGenController::class,'index'])->name('index');
    Route::get('/bulkimport', [CrudGenController::class,'bulkImport'])->name('bulkimport');
    Route::Post('/bulkimport/generate', [CrudGenController::class,'bulkImportGenerate'])->name('bulkimport.generate');
    Route::post('/generate', [CrudGenController::class,'generate'])->name('generate');
    Route::get('/getcol', [CrudGenController::class,'getColumns'])->name('getcol');
});

Route::group(['namespace' => 'Admin\ConstantManagement', 'prefix' => 'backend/slider-types','as' =>'backend.constant-management.slider_types.'], function () {
    Route::get('index', ['uses' => 'SliderTypeController@index', 'as' => 'index']);
    Route::get('create', ['uses' => 'SliderTypeController@create', 'as' => 'create']);
    Route::post('store', ['uses' => 'SliderTypeController@store', 'as' => 'store']);
    Route::get('edit/{slider_type}', ['uses' => 'SliderTypeController@edit', 'as' => 'edit']);
    Route::post('update/{slider_type}', ['uses' => 'SliderTypeController@update', 'as' => 'update']);
    Route::get('delete/{slider_type}', ['uses' => 'SliderTypeController@destroy', 'as' => 'destroy']);
}); 

Route::group(['namespace' => 'Backend\ConstantManagement', 'prefix' => 'backend/constant-management/sliders','as' =>'backend.constant-management.sliders.'], function () {
    Route::get('index', ['uses' => 'SliderController@index', 'as' => 'index']);
    Route::get('create', ['uses' => 'SliderController@create', 'as' => 'create']);
    Route::post('store', ['uses' => 'SliderController@store', 'as' => 'store']);
    Route::get('edit/{slider}', ['uses' => 'SliderController@edit', 'as' => 'edit']);
    Route::post('update/{slider}', ['uses' => 'SliderController@update', 'as' => 'update']);
    Route::get('delete/{slider}', ['uses' => 'SliderController@destroy', 'as' => 'destroy']);
}); 

    Route::group(['namespace' => 'Admin\ConstantManagement', 'prefix' => 'backend/newsletter','as' =>'backend/constant-management.news_letters.'], function () {
        Route::get('index', ['uses' => 'NewsLetterController@index', 'as' => 'index']);
        Route::get('create', ['uses' => 'NewsLetterController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'NewsLetterController@store', 'as' => 'store']);
        Route::get('edit/{news_letter}', ['uses' => 'NewsLetterController@edit', 'as' => 'edit']);
        Route::post('update/{news_letter}', ['uses' => 'NewsLetterController@update', 'as' => 'update']);
        Route::get('delete/{news_letter}', ['uses' => 'NewsLetterController@destroy', 'as' => 'destroy']);
        Route::get('/launchcampaign', ['uses' => 'NewsLetterController@launchcampaignShow', 'as' => 'launchcampaign.show']);
        Route::post('launchcampaign', ['uses' => 'NewsLetterController@runCampaign', 'as' => 'run.campaign']);
    }); 
    

    Route::group(['namespace' => 'Admin', 'prefix' => 'backend/site-content-managements','as' =>'backend.site_content_managements.'], function () {
        Route::get('index', ['uses' => 'SiteContentManagementController@index', 'as' => 'index']);
        Route::get('create', ['uses' => 'SiteContentManagementController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'SiteContentManagementController@store', 'as' => 'store']);
        Route::get('edit/{site_content_management}', ['uses' => 'SiteContentManagementController@edit', 'as' => 'edit']);
        Route::post('update/{site_content_management}', ['uses' => 'SiteContentManagementController@update', 'as' => 'update']);
        Route::get('delete/{site_content_management}', ['uses' => 'SiteContentManagementController@destroy', 'as' => 'destroy']);
    }); 
    Route::group(['namespace' => 'Admin', 'prefix' => 'backend/faqs','as' =>'backend/constant-management.faqs.'], function () {
        Route::get('index', ['uses' => 'FaqController@index', 'as' => 'index']);
        Route::get('create', ['uses' => 'FaqController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'FaqController@store', 'as' => 'store']);
        Route::get('edit/{faq}', ['uses' => 'FaqController@edit', 'as' => 'edit']);
        Route::post('update/{faq}', ['uses' => 'FaqController@update', 'as' => 'update']);
        Route::get('delete/{faq}', ['uses' => 'FaqController@destroy', 'as' => 'destroy']);
    });

Route::group(['middleware' => 'can:manage_orders','namespace' => 'Admin', 'prefix' => 'panel/orders','as' =>'panel.orders.'], function () {
    Route::get('', ['uses' => 'OrderController@index', 'as' => 'index']);
    Route::any('/print', ['uses' => 'OrderController@print', 'as' => 'print']);
    Route::get('create', ['uses' => 'OrderController@create', 'as' => 'create']);
    Route::post('store', ['uses' => 'OrderController@store', 'as' => 'store']);
    Route::get('/{order}', ['uses' => 'OrderController@show', 'as' => 'show']);
    Route::get('invoice/{order}', ['uses' => 'OrderController@invoice', 'as' => 'invoice']);
    Route::get('show/{order}', ['uses' => 'OrderController@show', 'as' => 'show']);
    Route::post('update/{order}', ['uses' => 'OrderController@update', 'as' => 'update']);
    Route::get('delete/{order}', ['uses' => 'OrderController@destroy', 'as' => 'destroy']);
}); 
    
    
    

Route::group(['namespace' => 'Panel', 'prefix' => 'panel/payouts','as' =>'panel.payouts.'], function () {
        Route::get('', ['uses' => 'PayoutController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'PayoutController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'PayoutController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'PayoutController@store', 'as' => 'store']);
        Route::get('/{payout}', ['uses' => 'PayoutController@show', 'as' => 'show']);
        Route::get('edit/{payout}', ['uses' => 'PayoutController@edit', 'as' => 'edit']);
        Route::post('update-status/{payout}/', ['uses' => 'PayoutController@updateStatus', 'as' => 'status']);
        Route::post('update/{payout}', ['uses' => 'PayoutController@update', 'as' => 'update']);
        Route::get('delete/{payout}', ['uses' => 'PayoutController@destroy', 'as' => 'destroy']);
    }); 
    
    
    

Route::group(['namespace' => 'Panel', 'prefix' => 'panel/user-addres','as' =>'panel.user_addres.'], function () {
        Route::get('', ['uses' => 'UserAddresController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'UserAddresController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'UserAddresController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'UserAddresController@store', 'as' => 'store']);
        Route::get('/{user_addre}', ['uses' => 'UserAddresController@show', 'as' => 'show']);
        Route::get('edit/{user_addre}', ['uses' => 'UserAddresController@edit', 'as' => 'edit']);
        Route::post('update/{user_addre}', ['uses' => 'UserAddresController@update', 'as' => 'update']);
        Route::get('delete/{user_addre}', ['uses' => 'UserAddresController@destroy', 'as' => 'destroy']);
    }); 

    
    Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/filemanager','as' =>'panel.filemanager.'], function () {
            Route::get('', ['uses' => 'FileManager@index', 'as' => 'index']);
    }); 
    Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/qr','as' =>'panel.qr.'], function () {
            Route::get('', ['uses' => 'QRController@index', 'as' => 'index']);
    }); 
    Route::group(['middleware' => 'auth','namespace' => 'Panel', 'prefix' => 'panel/map','as' =>'panel.map.'], function () {
            Route::get('', ['uses' => 'QRController@map', 'as' => 'index']);
    }); 
    
    

Route::group(['namespace' => 'Panel', 'prefix' => 'panel/user-kycs','as' =>'panel.user_kycs.'], function () {
        Route::get('', ['uses' => 'UserKycController@index', 'as' => 'index']);
        Route::any('/print', ['uses' => 'UserKycController@print', 'as' => 'print']);
        Route::get('create', ['uses' => 'UserKycController@create', 'as' => 'create']);
        Route::post('store', ['uses' => 'UserKycController@store', 'as' => 'store']);
        Route::get('/{user_kyc}', ['uses' => 'UserKycController@show', 'as' => 'show']);
        Route::get('edit/{user_kyc}', ['uses' => 'UserKycController@edit', 'as' => 'edit']);
        Route::post('update/{user_kyc}', ['uses' => 'UserKycController@update', 'as' => 'update']);
        Route::get('delete/{user_kyc}', ['uses' => 'UserKycController@destroy', 'as' => 'destroy']);
    }); 
    
    