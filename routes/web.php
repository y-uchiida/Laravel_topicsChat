<?php

/* コントローラのクラスを読み込み */
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\Admin\HomeController;

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

/* Topicsの新規作成と更新以外の処理をルーティング */
Route::resource('/topics', TopicController::class)->except(['create', 'update'])->middleware(['auth']);

/* message 関連の処理をルーティング */
Route::resource('/topics/{topic}/messages', MessageController::class)->except(['create', 'update'])->middleware(['auth']);

/* 管理者関連のログイン前の処理 */
// Route::group(['prefix' => 'admin'], function () {
//     Route::get('login', [LoginController::class, 'showLoginForm'])->name('admin.login');
//     Route::post('login', [LoginController::class, 'login']);
// });

/* 管理者関連のログイン後の処理 */
Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function(){
    Route::get('home', [HomeController::class, 'index'])->name('admin.home');
});

require __DIR__ . '/auth.php';

/* 一般ユーザーのルーティングパスと分けるため、プレフィックスを付けてadmin関連のルーティングをインクルード */
Route::prefix('admin')->name('admin.')->group(function(){
    Route::get('/home', function () {
        return view('admin.home');
    })->middleware(['auth:admin'])->name('admin.home');
    require __DIR__.'/admin.php';
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin', 'as' => 'admin.'], function(){

});
