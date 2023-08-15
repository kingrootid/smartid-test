<?php

use App\Http\Controllers\AjaxController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\ExportController;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'dashboard']);
    Route::get('pengisian/{uuid}', [DashboardController::class, 'pengisian']);
    Route::get('export/{uuid}', [ExportController::class, 'export']);
    Route::get('export/show/{uuid}', [ExportController::class, 'show']);



    /* Admin Route */
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/opd', [DashboardController::class, 'adminOpd']);
        Route::get('/master/klaster', [DashboardController::class, 'masterKlaster']);
        Route::get('/master/sub-klaster', [DashboardController::class, 'masterSubKlaster']);
        Route::get('/schedule', [DashboardController::class, 'adminSchedule']);
    });
    /* Data Route */
    Route::group(['prefix' => 'data'], function () {
        Route::get('/opd', [DataController::class, 'user']);
        Route::get('/opd/{id}', [DataController::class, 'getUser']);
        Route::get('/klaster', [DataController::class, 'klaster']);
        Route::get('/klaster/{id}', [DataController::class, 'getKlaster']);
        Route::get('/sub-klaster', [DataController::class, 'subKlaster']);
        Route::get('/sub-klaster/{id}', [DataController::class, 'getSubKlaster']);
        Route::get('/schedule', [DataController::class, 'scheduleInput']);
        Route::get('/schedule/{id}', [DataController::class, 'getScheduleInput']);
        Route::get('/getForm/{uuid}', [DataController::class, 'getFormInputUUID']);
    });
    /* Ajax Route */
    Route::group(['prefix' => 'ajax'], function () {
        Route::post('/opd', [AjaxController::class, 'opd']);
        Route::post('/klaster', [AjaxController::class, 'klaster']);
        Route::post('/sub-klaster', [AjaxController::class, 'subKlaster']);
        Route::post('/schedule', [AjaxController::class, 'scheduleInput']);
        Route::post('/pengisian', [AjaxController::class, 'userInput']);
        Route::post('/check-info', [AjaxController::class, 'getInfoInput']);
        Route::post('/update-pengisian', [AjaxController::class, 'updateInput']);
    });
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('login', [AuthController::class, 'authorization']);
