<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonkiController;

Route::get('/donki/instruments', [DonkiController::class, 'getInstruments']);
Route::get('/donki/activity-ids', [DonkiController::class, 'getActivityIDs']);
Route::get('/donki/instrument-usage', [DonkiController::class, 'getInstrumentUsage']);
Route::post('/donki/instrument-activity-usage', [DonkiController::class, 'getInstrumentActivityUsage']);