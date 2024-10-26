<?php

use App\Enums\Period;
use App\Models\Leaderboard;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('leaderboard');
});

Route::view('/leaderboard', 'leaderboard')->name('leaderboard');
