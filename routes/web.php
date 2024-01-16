<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);

});

Route::get('/dashboard', function () {

    return Inertia::render('Dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // 1st Callange
        // Attendance
        Route::get('/attendance', [App\Http\Controllers\AppHumanResources\AttendanceController::class, 'index'])->name('attendance.index');

    // 2nd Callange
        // Multiple Occurrance
        Route::get('/multiple-occurrance-in-array', [App\Http\Controllers\AppHumanResources\AttendanceController::class, 'findElementsOccurringMoreThanOnce'])->name('multiple-occurrance.find');
    
    // 4th Callange
        // Group By Owners
        Route::get('/group-by-owners', [App\Http\Controllers\AppHumanResources\AttendanceController::class, 'groupByOwners'])->name('group-by-owners.service');

    // Auth Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
