<?php

use App\Http\Controllers\CronController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::any('env-editor', function () {
    return redirect('/');
})->where('anything', '.*');
Route::any('env-editor/key', function () {
    return redirect('/');
})->where('anything', '.*');


Route::post('subscribe/store', [HomeController::class, 'subscribeStore'])->name('subscribe.store');

Route::group(['prefix' => localeRoutePrefix(), 'middleware' => 'isInstalled'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('check.landing.page');
    Route::get('language/{lang}', [HomeController::class, 'changeLanguage'])->name('lang');
    Route::get('cache-clear', [HomeController::class, 'cacheClear'])->name('cache.clear');
    Route::get('page/{link}', [HomeController::class, 'page']);
    Route::get('cron/{key}', [CronController::class, 'index']);
    Route::get('migrate/addons', [CronController::class, 'AddonsMigrate'])->name('migrate.addons');

});

require __DIR__.'/auth.php';
