<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TwoFaController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MainController::class, 'index'])->name('index');

Route::group([
    'middleware' => 'AdminManagerSupport',
    'prefix' => 'admin'
], function () {
    Route::get('/home', [AdminController::class, 'home'])->name('admin.home');
    Route::get('/orders', [OrderController::class, 'showOrders'])->name('admin.orders');
    Route::get('/orders/{id}', [OrderController::class, 'showOrderDetails'])->name('admin.orderDetails');

    Route::get('/categories', [CategoryController::class, 'showCategories'])->name('admin.categories');
    Route::get('/categories/{id}', [CategoryController::class, 'showCategory'])->name('admin.showCategory');

    Route::get('/products', [ProductController::class, 'showProducts'])->name('admin.products');
    Route::get('/products/{id}', [ProductController::class, 'showProduct'])->name('admin.showProduct');
});


Route::group([
    'middleware' => 'AdminManager',
    'prefix' => 'admin'
], function () {
    Route::get('/categories/{id}/edit', [CategoryController::class, 'showEditCategory'])->name('admin.showEditCategory');
    Route::post('/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('admin.editCategory');
    Route::get('/category/create', [CategoryController::class, 'showCreateCategory'])->name('admin.showCreateCategory');
    Route::post('/category/create', [CategoryController::class, 'createCategory'])->name('admin.createCategory');
    Route::get('/categories/{id}/delete', [CategoryController::class, 'deleteCategory'])->name('admin.deleteCategory');

    Route::get('/products/{id}/edit', [ProductController::class, 'showEditProduct'])->name('admin.showEditProduct');
    Route::post('/products/{id}/edit', [ProductController::class, 'editProduct'])->name('admin.editProduct');
    Route::get('/product/create', [ProductController::class, 'showCreateProduct'])->name('admin.showCreateProduct');
    Route::post('/product/create', [ProductController::class, 'createProduct'])->name('admin.createProduct');
    Route::get('/products/{id}/delete', [ProductController::class, 'deleteProduct'])->name('admin.deleteProduct');

    Route::get('/properties', [PropertyController::class, 'showProperties'])->name('admin.properties');
    Route::get('/properties/{id}/edit', [PropertyController::class, 'showEditProperty'])->name('admin.showEditProperty');
    Route::post('/properties/{id}/edit', [PropertyController::class, 'editProperty'])->name('admin.editProperty');
    Route::get('/properties/create', [PropertyController::class, 'showCreateProperty'])->name('admin.showCreateProperty');
    Route::post('/properties/create', [PropertyController::class, 'createProperty'])->name('admin.createProperty');
    Route::get('/properties/{id}/delete', [PropertyController::class, 'deleteProperty'])->name('admin.deleteProperty');

    Route::get('/properties/{propertyId}/values', [PropertyController::class, 'showPropertyValues'])->name('admin.propertyValues');
    Route::get('/values/{valueId}/edit', [PropertyController::class, 'showEditPropertyValue'])->name('admin.showEditPropertyValue');
    Route::post('/values/{valueId}/edit', [PropertyController::class, 'editPropertyValue'])->name('admin.editPropertyValue');
    Route::get('/properties/{propertyId}/values/create', [PropertyController::class, 'showCreatePropertyValue'])->name('admin.showCreatePropertyValue');
    Route::post('/properties/{propertyId}/values/create', [PropertyController::class, 'createPropertyValue'])->name('admin.createPropertyValue');
    Route::get('/values/{valueId}/delete', [PropertyController::class, 'deletePropertyValue'])->name('admin.deletePropertyValue');
});


Route::group([
    'middleware' => 'AdminSupport',
    'prefix' => 'admin'
], function () {
    Route::get('/tickets', [AdminController::class, 'tickets'])->name('admin.tickets');
    Route::get('/tickets/{id}', [AdminController::class, 'ticketDetails'])->name('admin.ticketDetails');
    Route::post('/tickets/response', [AdminController::class, 'ticketResponse'])->name('admin.ticketResponse');
});


Route::group([
    'middleware' => 'Admin',
    'prefix' => 'admin'
], function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles');
    Route::get('/roles/{userId}/edit', [RoleController::class, 'showEditUserRole'])->name('admin.showEditUserRole');
    Route::post('/roles/{userId}/edit', [RoleController::class, 'EditUserRole'])->name('admin.EditUserRole');
    Route::get('/roles/create', [RoleController::class, 'showCreateUserRole'])->name('admin.showCreateUserRole');
    Route::post('/roles/create', [RoleController::class, 'createUserRole'])->name('admin.CreateUserRole');
    Route::get('/roles/{userId}/delete', [RoleController::class, 'deleteUserRole'])->name('admin.deleteUserRole');
});


Route::get('/basket', [BasketController::class, 'basket'])->name('basket');
Route::post('/basket/add/{productId}/{sizeId?}', [BasketController::class, 'basketAdd'])->name('basket-add');
Route::post('/basket/remove/{productId}/{sizeId}', [BasketController::class, 'basketRemove'])->name('basket-remove');

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/basket/place', [BasketController::class, 'basketPlace'])->name('basket-place');
    Route::post('/basket/confirm', [BasketController::class, 'basketConfirm'])->name('basket-confirm');

    Route::get('/orders', [MainController::class, 'showOrders'])->name('orders');
    Route::get('/orders/{id}', [MainController::class, 'showOrderDetails'])->name('orderDetails');

    Route::get('order/2fa/show', [TwoFaController::class, 'orderShow2Fa'])->name('orderShow2Fa');
    Route::post('order/2fa/check', [TwoFaController::class, 'orderCheck2Fa'])->name('orderCheck2Fa');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login_process', [AuthController::class, 'login_process'])->name('login_process');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register_process', [AuthController::class, 'register_process'])->name('register_process');

    Route::get('/register/2fa/show', [TwoFaController::class, 'registerShow2Fa'])->name('registerShow2Fa');
    Route::post('/register/2fa/check', [TwoFaController::class, 'registerCheck2Fa'])->name('registerCheck2Fa');

    Route::get('login/2fa/show', [TwoFaController::class, 'loginShow2Fa'])->name('loginShow2Fa');
    Route::post('login/2fa/check', [TwoFaController::class, 'loginCheck2Fa'])->name('loginCheck2Fa');

    Route::get('/resetPassword/send', [AuthController::class, 'showResetPasswordSend'])->name('showResetPasswordSend');
    Route::post('/resetPassword/send', [AuthController::class, 'resetPasswordSend'])->name('resetPasswordSend');
    Route::get('/resetPassword/set', [AuthController::class, 'showResetPasswordSet'])->name('showResetPasswordSet');
    Route::post('/resetPassword/set', [AuthController::class, 'resetPasswordSet'])->name('resetPasswordSet');
    Route::get('resetPassword/2fa/show', [TwoFaController::class, 'resetPasswordShow2Fa'])->name('resetPasswordShow2Fa');
    Route::post('resetPassword/2fa/check', [TwoFaController::class, 'resetPasswordCheck2Fa'])->name('resetPasswordCheck2Fa');


});

Route::get('/search', [MainController::class, 'search'])->name('search');

Route::post('/payment/callback', [BasketController::class, 'paymentCallback'])->name('paymentCallback');

Route::get('/feedback', [MainController::class, 'showFeedback'])->name('showFeedback');
Route::post('/feedback', [MainController::class, 'saveFeedback'])->name('saveFeedback');

//Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/categories/{gender}', [MainController::class, 'categoryGender'])->name('categoryGender');
Route::get('/categories/{gender}/{category}', [MainController::class, 'category'])->name('category');

Route::get('/product/{category}/{product?}', [MainController::class, 'product'])->name('product');

