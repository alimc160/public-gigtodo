<?php


use App\Http\Controllers\Admin\LoginController;
use Illuminate\Support\Facades\Route;


Route::get('login',[LoginController::class,'login'])->name('admin.login');
Route::post('login',[LoginController::class,'loginPost'])->name('login.post');
Route::middleware('auth')->name('admin.')->group(function (){
    Route::get('dashboard',function (){
        return view('admin.dashboard');
    })->name('dashboard');
    Route::get('categories/create',[\App\Http\Controllers\Admin\CategoryController::class,'create'])->name('categories.create');
    Route::post('categories/store',[\App\Http\Controllers\Admin\CategoryController::class,'addCategory'])->name('categories.store');
    Route::get('categories',[\App\Http\Controllers\Admin\CategoryController::class,'index'])->name('categories.index');
    Route::get('categories/{id}/edit',[\App\Http\Controllers\Admin\CategoryController::class,'edit'])->name('categories.edit');
    Route::post('categories/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'updateCategory'])->name('categories.update');
    Route::post('categories/{id}',[\App\Http\Controllers\Admin\CategoryController::class,'deleteCategory'])->name('categories.destroy');
    Route::get('users',[\App\Http\Controllers\Admin\UserController::class,'index'])->name('users.index');
    Route::post('users/change-status/{id}',[\App\Http\Controllers\Admin\UserController::class,'changeStatus'])->name('users.change.status');
    Route::get('/get-gig-listing',[\App\Http\Controllers\Admin\GigController::class,'getGigListing'])->name('gig.listing');
    Route::post('/change-status-gig',[\App\Http\Controllers\Admin\GigController::class,'changeStatus'])->name('change.status');
});
