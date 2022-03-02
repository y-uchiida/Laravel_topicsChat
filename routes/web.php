<?php

use Illuminate\Support\Facades\Route;

/* コントローラのクラスを読み込み */
use App\Http\Controllers\TopicController;

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

/* Topicsの新規作成と更新以外の処理をルーティング */
Route::resource('/topics', TopicController::class)->except(['create', 'update'])->middleware(['auth']);

require __DIR__.'/auth.php';
