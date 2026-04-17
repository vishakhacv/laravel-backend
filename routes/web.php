<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'name' => 'Task & Project Management API',
        'version' => '1.0.0',
    ]);
});
