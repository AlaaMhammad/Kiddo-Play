<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('language/{locale}', function ($locale) {
//     if (in_array($locale, ['en', 'ar'])) {
//         session()->put('locale', $locale);
//     }
//     return redirect()->back();
// })->name('lang.switch');

//   Route::post('change-language', function (Request $request) {
//     $lang = $request->input('lang');
//     App::setLocale($lang);
//     Session::put('locale', $lang);
//     return redirect()->back();
// })->name('change.language');

Route::get('ar', function () {
    session()->put('locale', 'ar');
    return redirect()->back();
})->name('ar');

Route::get('en', function () {
     session()->put('locale', 'en');
    return redirect()->back();
})->name('en');
