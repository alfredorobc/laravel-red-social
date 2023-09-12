<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeController::class)->name('home');

Route::group(['middleware' => 'web'], function () {
    Route::prefix('auth')->group(function () {
        Route::get('/register', [RegisterController::class, 'index'])->name('register');
        Route::post('/register', [RegisterController::class, 'store']);

        Route::get('/login', [LoginController::class, 'index'])->name('login');
        Route::post('/login', [LoginController::class, 'store']);

        Route::post('/logout', [LogoutController::class, 'store'])->name('logout');
    });

    Route::get('/editar-perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');

    Route::get('/{user:username}', [PostController::class, 'index'])->name('post.index');
    Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
    Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

    Route::prefix('posts')->group(function () {
        Route::get('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/create', [PostController::class, 'store'])->name('post.store');
        Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');
        Route::delete('/{post}',[PostController::class,'destroy'])->name('post.destroy');
        Route::post('/{post}/likes',[LikeController::class,'store'])->name('likes.store');
        Route::delete('/{post}/likes',[LikeController::class,'destroy'])->name('likes.destroy');
    });
});

Route::get('/{any}', function () {
    return redirect()->route('home');
})->where('any', '.*');

