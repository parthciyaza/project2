<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropdownController;


Route::get('dependent-dropdown', [DropdownController::class, 'index']);
Route::post('api/fetch-states', [DropdownController::class, 'fetchState']);
Route::post('api/fetch-cities', [DropdownController::class, 'fetchCity']);

Route::post('/insertinfo',[DropdownController::class,'insertinfo']);
Route::get('/deleteinfo/{id}',[DropdownController::class,'deleteinfo']);
Route::get('/fatchinfo/{id}',[DropdownController::class,'fatchinfo']);
Route::post('/updateinfo/{id}',[DropdownController::class,'updateinfo']);
Route::post('/search',[DropdownController::class,'search']);
