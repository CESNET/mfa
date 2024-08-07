<?php

use App\Services\ErrorService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('language/{language}', function ($locale = null) {
    if (isset($locale) && in_array($locale, config('app.locales'))) {
        App::setLocale($locale);
        Session::put('locale', $locale);
    }

    return redirect()->back();
});

Route::view('up', 'health-up');

Route::view('/', 'welcome');
Route::view('login', 'mfa', ['e' => []]);
Route::get('error', function () {
    return view('mfa', ['e' => (new ErrorService)->getErrors()]);
});
