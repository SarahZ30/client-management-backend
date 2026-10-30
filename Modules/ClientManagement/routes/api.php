<?php

use Illuminate\Support\Facades\Route;
use Modules\ClientManagement\app\Http\Controllers\ClientManagementController;

// client routes
Route::prefix('clients')->group(function () {
    // get data
    Route::get('getalldata', [
        ClientManagementController::class,
        'getAllData',
    ]);

    // store data
    Route::post('storeclient', [
        ClientManagementController::class,
        'storeClient',
    ]);

    // update client
    Route::put('updateclient', [
        ClientManagementController::class,
        'updateClient',
    ]);

    // delete client
    Route::delete('deleteclient', [
        ClientManagementController::class,
        'deleteClient',
    ]);

    // search clients by phone number
    Route::get('searchbyphone', [
        ClientManagementController::class,
        'searchByPhone',
    ]);
});
