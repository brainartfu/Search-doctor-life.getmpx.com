<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::get('/', [PostController::class, 'search']);
Route::get('/post', [PostController::class, 'index']);
Route::get('/search', [PostController::class, 'search'])->name('web_post');
Route::get('/get-category', [PostController::class, 'get_category'])->name('web_category');
Route::post('/search-list', [PostController::class, 'search_list'])->name('web_list');
