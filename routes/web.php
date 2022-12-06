<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Fondend\HomeController;
use App\Models\Category;
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

Route::get('/',[HomeController::class, 'index'])->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
    ])->group(function () {
        Route::get('/dashboard', function () {
            return view('backend.dashboard.index');
        })->name('dashboard');

        Route::controller(CategoryController::class)->group(function(){
            Route::get('/category/create','create')->name('category-create');
            Route::post('/category/store', 'store')->name('category-store');
            Route::get('/categories','index')->name('category-manage');
            Route::get('/category/delete/{cat_id}',  'delete')->name('category-delete');
            Route::get('/category/edit/{cat_id}',  'edit')->name('category-edit');
            Route::post('/category/update/{cat_id}',  'update')->name('category-update');
        });
        
});
