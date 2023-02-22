<?php

use App\Services\ErrorService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('language/{locale}', function ($locale = null) {
    if (isset($locale) && in_array($locale, config('app.locales'))) {
        app()->setLocale($locale);
        session()->put('locale', $locale);
    }

    return redirect()->back();
});

Route::view('/', 'welcome');
Route::view('login', 'mfa', ['e' => []]);
Route::get('error', function () {
    return view('mfa', ['e' => (new ErrorService)->getErrors()]);
});
