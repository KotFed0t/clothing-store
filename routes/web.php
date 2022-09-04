<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MainController::class, 'index'])->name('index');

Route::group([
    'middleware' => 'CheckIsAdmin',
    'prefix' => 'admin'
], function () {
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/orders', [OrderController::class, 'showOrders'])->name('admin.orders');
    Route::get('/orders/{id}', [OrderController::class, 'showOrderDetails'])->name('admin.orderDetails');

    Route::get('/categories', [CategoryController::class, 'showCategories'])->name('admin.categories');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'showEditCategory'])->name('admin.showEditCategory');
    Route::post('/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('admin.editCategory');
    Route::get('/categories/create', [CategoryController::class, 'showCreateCategory'])->name('admin.showCreateCategory');
    Route::post('/categories/create', [CategoryController::class, 'createCategory'])->name('admin.createCategory');
    Route::get('/categories/{id}/delete', [CategoryController::class, 'deleteCategory'])->name('admin.deleteCategory');
    Route::get('/categories/{id}', [CategoryController::class, 'showCategory'])->name('admin.showCategory');

    Route::get('/products', [ProductController::class, 'showProducts'])->name('admin.products');
    Route::get('/products/{id}/edit', [ProductController::class, 'showEditProduct'])->name('admin.showEditProduct');
    Route::post('/products/{id}/edit', [ProductController::class, 'editProduct'])->name('admin.editProduct');
    Route::get('/products/create', [ProductController::class, 'showCreateProduct'])->name('admin.showCreateProduct');
    Route::post('/products/create', [ProductController::class, 'createProduct'])->name('admin.createProduct');
    Route::get('/products/{id}/delete', [ProductController::class, 'deleteProduct'])->name('admin.deleteProduct');
    Route::get('/products/{id}', [ProductController::class, 'showProduct'])->name('admin.showProduct');
});

Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');
Route::post('/basket/remove/{id}', [BasketController::class, 'basketRemove'])->name('basket-remove');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/basket/place', [BasketController::class, 'basketPlace'])->name('basket-place');
    Route::post('/basket/place', [BasketController::class, 'basketConfirm'])->name('basket-confirm');

    Route::get('/orders', [MainController::class, 'showOrders'])->name('orders');
    Route::get('/orders/{id}', [MainController::class, 'showOrderDetails'])->name('orderDetails');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login_process', [AuthController::class, 'login_process'])->name('login_process');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register_process', [AuthController::class, 'register'])->name('register_process');
});

Route::get('/email_confirmation', [AuthController::class, 'emailConfirmation'])->name('email_confirmation');

Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/categories/{category}', [MainController::class, 'category'])->name('category');

Route::get('/categories/{category}/{product?}', [MainController::class, 'product'])->name('product');

