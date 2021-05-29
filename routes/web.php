<?php

use App\Http\Livewire\ShowPosts;
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

//en este caso utilizo el componente de livewire ShowPosts como controlador de rutas
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', ShowPosts::class)->name('dashboard');
