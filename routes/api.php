<?php

use App\Http\Controllers\ListAllCountriesController;
use Illuminate\Support\Facades\Route;

//Route::get('countries', [ListAllCountriesController::class, 'index']);
//    ->middleware('auth'); // auth0 guard works when the api endpoint defined as web, but it doesn't work when route defined as api and blocks request with unauthorized error message and 401 status code

