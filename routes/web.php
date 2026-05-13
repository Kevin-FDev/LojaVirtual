<?php

use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TypesController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ProductsController::class, 'vitrine'])->name('vitrine');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

   
    Route::get('/products', [ProductsController::class, 'index'])->name('products'); // Listagem adm
    Route::get('/products/new', [ProductsController::class, 'create'])->name('products.create'); // Tela de cadastro
    Route::post('/products/new', [ProductsController::class, 'store'])->name('products.store'); // Ação de salvar
    Route::get('/products/update/{id}', [ProductsController::class, 'edit'])->name('products.edit'); // Tela de edição
    Route::post('/products/update/', [ProductsController::class, 'update'])->name('products.update'); // Ação de atualizar
    Route::get('/products/delete/{id}', [ProductsController::class, 'destroy'])->name('products.destroy'); // Ação de excluir


    Route::get('/types/new', [TypesController::class, 'create'])->name('types.create'); // Tela de cadastro de tipo
    Route::post('/types/new', [TypesController::class, 'store'])->name('types.store'); // Ação de salvar tipo
});

require __DIR__ . '/auth.php';