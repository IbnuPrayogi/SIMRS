<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SendDataController;
use App\Http\Controllers\Api\PresensiApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/kirimdata/presensi', [PresensiApiController::class, 'terima'])->withoutMiddleware('auth');
Route::post('/kirimdata/bagian', [SendDataController::class, 'terimabagian']);
Route::get('/fetch/user', [PresensiApiController::class, 'getAllUsers']);

