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
    return view('auth.login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/posts', [App\Http\Controllers\HomeController::class, 'getPosts'])->name('posts.getPosts');
    Route::post('/posts/add', [App\Http\Controllers\HomeController::class, 'create'])->name('posts.create');
    Route::get('/posts/edit/{id}', [App\Http\Controllers\HomeController::class, 'edit']);
    Route::get('/post/show/{id}', [App\Http\Controllers\HomeController::class, 'show']);
    Route::post('posts/update/{id}', [App\Http\Controllers\HomeController::class, 'update']);
    Route::delete('posts/delete/{id}', [App\Http\Controllers\HomeController::class, 'delete']);
    Route::get('/tags', [App\Http\Controllers\TagController::class, 'getTags']);
    Route::post('/post/{id}/comment', [App\Http\Controllers\CommentController::class, 'store']);
    Route::post('/post/{id}/comment/reply', [App\Http\Controllers\CommentController::class, 'replyStore']);
    Route::post('/post/{id}/like', [App\Http\Controllers\CommentController::class, 'like']);
            
});



