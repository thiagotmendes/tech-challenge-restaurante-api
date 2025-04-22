<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/api/documentation');

Route::get('/documentation', function () {
    return view('l5-swagger::index');
});
