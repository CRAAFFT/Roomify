<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;
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

Route::get('/', [PageController::class, 'homeUser'])->name('homeUser');
// Route::get('/detail{hotel_id}', [PageController::class, 'detailHotel'])->name('detailHotel');

Route::get('/homeOwner', [PageController::class, 'homeOwner'])->name('homeOwner');
Route::get('/addHotel', [PageController::class, 'addHotel'])->name('addHotel');
Route::post('/addHotel', [OwnerController::class, 'addHotel'])->name('postAddHotel');
Route::get('/updateHotel/{hotel_id}', [PageController::class, 'updateHotel'])->name('updateHotel');
Route::put('/updateHotel/{hotel_id}', [OwnerController::class, 'updateHotel'])->name('putUpdateHotel');
Route::delete('/deleteHotel/{hotel_id}', [OwnerController::class, 'deleteHotel'])->name('deleteHotel');

Route::get('/homeAdmin', [PageController::class, 'homeAdmin'])->name('homeAdmmin');

Route::get('/register', [PageController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('postRegister');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('postLogin');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');