<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/show-job-email', function () {
    dump((bool)file_exists(base_path('email')));
})->middleware(['auth']);

Route::get('/create-job-email', function () {
    dump((bool)touch(base_path('email')));
})->middleware(['auth']);

Route::get('/delete-job-email', function () {
    dump((bool)unlink(base_path('email')));
})->middleware(['auth']);

Route::get('/start-job', function () {
    dump((bool)touch(base_path('job')));
})->middleware(['auth']);

Route::get('/show-job', function () {
    dump((bool)file_exists(base_path('job')));
})->middleware(['auth']);

Route::get('/stop-job', function () {
    dump((bool)unlink(base_path('job')));
})->middleware(['auth']);

Route::get('/create-s3-file', function () {
    $uuid = \Illuminate\Support\Str::uuid();
    dump($uuid);
    return Storage::disk('s3')->put('files/' . $uuid . '.txt', 'test - ' . $uuid);
})->middleware(['auth']);

Route::get('/show-s3-file/{uuid}', function ($uuid) {
    return Storage::disk('s3')->get('files/' . $uuid . '.txt');
})->middleware(['auth']);

Route::get('/delete-s3-file/{uuid}', function ($uuid) {
    return Storage::disk('s3')->delete('files/' . $uuid . '.txt');
})->middleware(['auth']);