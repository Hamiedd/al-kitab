<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::prefix('v1')->group(function (){
    Route::get('sections',\App\Http\Controllers\Api\SectionController::class);
    Route::get('categories',\App\Http\Controllers\Api\CategoryController::class);
    Route::get('categories/{id}/contents',[\App\Http\Controllers\Api\ContentController::class,'show']);
    Route::get('sections/{id}/contents',[\App\Http\Controllers\Api\ContentController::class,'showBySection']);
    Route::get('contents',[\App\Http\Controllers\Api\ContentController::class,'index']);

    Route::get('settings',\App\Http\Controllers\Api\SettingController::class);
});
