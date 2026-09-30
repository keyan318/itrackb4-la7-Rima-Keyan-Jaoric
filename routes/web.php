<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\TeacherController;


Route::get('/', function () {
    return view('welcome');
});

//Movies
Route::get('/movies/featured', [MovieController::class, 'featured'])->name('movies.featured');

Route::get('/movies/filter/{value?}', function ($value = null) {
    if ($value) {
        return redirect()->route('movies.index', ['genre' => $value]);
    }
    return redirect()->route('movies.index');
});

Route::resource('movies', MovieController::class)
->only(['index', 'show', 'create','store']);




