<?php

use App\Http\Controllers\FilmController;
use App\Livewire\Codes;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('dashboard/codes', Codes::class)->name('dashboard.codes');
});


Route::get('/video', function () {
    return view('video');
})->name('video');

Route::get('/d/{key}', function($key){
    return Crypt::encrypt($key);
});


Route::get('video-src', [FilmController::class, 'streamVideo'])->name('videosrc');

require __DIR__.'/auth.php';
