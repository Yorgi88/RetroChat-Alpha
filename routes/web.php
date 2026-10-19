<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome-retro');
})->name('lobby');


Route::get('/rooms/create', function (){
    return view('rooms.create');
})->name('rooms.create');

Route::get('/rooms/join', function (){
    return view('rooms.join');
})->name('rooms.join');