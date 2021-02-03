<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/



if (count(request()->segments()) == 0) return;
    if (count(request()->segments()) >= 2) {
        $route = request()->segment(2);
        Route::get("/$route/{p?}", [App\Http\Controllers\Api\AppController::class, 'index']);
        Route::post("/$route/{p?}", [App\Http\Controllers\Api\AppController::class, 'index']);
    }


