<?php

use App\Http\Controllers\ProfileController;    // コメントアウトにする
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UsersController; // 追記
use App\Http\Controllers\TasksController; //追記

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/index', [TasksController::class, 'index']);
//Route::resource('tasks', TasksController::class);

///*
Route::get('/', function () {
    return view('welcome');
});
//*/


//Route::get('/dashboard', [TasksController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [TasksController::class, 'index'])->name('dashboard');

/*
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/

Route::middleware('auth')->group(function () {
    Route::resource('users', UsersController::class, ['only' => ['index', 'show']]);
    //Route::resource('tasks', TasksController::class, ['only' => ['store', 'destroy']]);
    Route::resource('tasks', TasksController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
