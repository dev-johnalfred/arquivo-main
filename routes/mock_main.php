<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

Route::get('/', function () {
    return;
})->middleware('role.redirect');

Route::get('/api-tester', function () {
    return Inertia::render('ApiTester');
});

