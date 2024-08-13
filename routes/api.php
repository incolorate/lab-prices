<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiHarvestController;

Route::post('/harvest', [ApiHarvestController::class, 'store']);