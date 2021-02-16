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

Route::post('/reply/store', 'App\Http\Controllers\CommentController@replyStore')->name('reply.add')->middleware(['auth']);
Route::resource('/posts', App\Http\Controllers\PostController::class);
Route::put('/pocket/boost', 'App\Http\Controllers\PocketController@boostPocket')->name('pocket.boost');
Route::put('/posts/{post}/boost', 'App\Http\Controllers\PostController@boost')->name('posts.boost');
Route::resource('/pocket', App\Http\Controllers\PocketController::class)->only(['index'])->middleware('auth');;
Route::resource('posts.comments', App\Http\Controllers\PostCommentController::class)->only(['store', 'update', 'edit', 'destroy'])->middleware('auth');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
