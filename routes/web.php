<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('home');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');

Route::get('/service', [App\Http\Controllers\HomeController::class, 'service'])->name('service');


Route::get('foods/food-details/{id}', [App\Http\Controllers\Foods\FoodsController::class, 'foodDetails'])->name('food.details');

//cart
Route::post('foods/food-details/{id}', [App\Http\Controllers\Foods\FoodsController::class, 'cart'])->name('food.cart');
Route::get('foods/cart', [App\Http\Controllers\Foods\FoodsController::class, 'displayCartItems'])->name('food.display.cart');
Route::get('foods/delete-cart/{id}', [App\Http\Controllers\Foods\FoodsController::class, 'deleteCartItems'])->name('food.delete.cart');


Route::post('foods/prepare-checkout', [App\Http\Controllers\Foods\FoodsController::class, 'prepareCheckout'])->name('prepare.checkout');
Route::get('foods/checkout', [App\Http\Controllers\Foods\FoodsController::class, 'checkout'])->name('food.checkout');
Route::post('foods/checkout', [App\Http\Controllers\Foods\FoodsController::class, 'storeCheckout'])->name('food.checkout.store');

Route::get('foods/pay', [App\Http\Controllers\Foods\FoodsController::class, 'payWithPaypal'])->name('foods.pay');
Route::get('foods/success', [App\Http\Controllers\Foods\FoodsController::class, 'success'])->name('foods.success');

Route::post('foods/booking', [App\Http\Controllers\Foods\FoodsController::class, 'bookingTables'])->name('food.booking.table');

Route::get('foods/menu', [App\Http\Controllers\Foods\FoodsController::class, 'menu'])->name('foods.menu');

Route::get('users/all-bookings', [App\Http\Controllers\Foods\User::class, 'getBookings'])->name('users.bookings');
Route::get('users/all-orders', [App\Http\Controllers\Foods\User::class, 'getOrders'])->name('users.orders');

Route::get('users/write-reviews', [App\Http\Controllers\Foods\User::class, 'viewReviews'])->name('users.reviews.create');
Route::post('users/write-reviews', [App\Http\Controllers\Foods\User::class, 'submitReview'])->name('users.reviews.store');


Route::get('admin/login', [App\Http\Controllers\Admins\AdminController::class, 'viewLogin'])->name('view.login')->middleware('checkforauth');
Route::post('admin/login', [App\Http\Controllers\Admins\AdminController::class, 'checkLogin'])->name('check.login');
Route::post('admin/logout', [App\Http\Controllers\Admins\AdminController::class, 'logout'])->name('admin.logout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::get('index', [App\Http\Controllers\Admins\AdminController::class, 'index'])->name('admins.dashboard');

    //all-admins
    Route::get('all-admins', [App\Http\Controllers\Admins\AdminController::class, 'allAdmins'])->name('admins.all');
    Route::get('admins-create', [App\Http\Controllers\Admins\AdminController::class, 'createAdmin'])->name('admins.create');
    Route::post('admins-create', [App\Http\Controllers\Admins\AdminController::class, 'storeAdmin'])->name('admins.store');

    //orders
    Route::get('all-orders', [App\Http\Controllers\Admins\AdminController::class, 'allOrders'])->name('orders.all');
    Route::put('orders/{id}/update-status', [App\Http\Controllers\Admins\AdminController::class, 'updateOrderStatus'])->name('orders.update.status');
    Route::delete('orders/{id}', [App\Http\Controllers\Admins\AdminController::class, 'deleteOrder'])->name('orders.delete');
    
    //bookings
    Route::get('all-bookings', [App\Http\Controllers\Admins\AdminController::class, 'allBookings'])->name('bookings.all');
    Route::put('bookings/{id}/update-status', [App\Http\Controllers\Admins\AdminController::class, 'updateBookingStatus'])->name('bookings.update.status');
    Route::delete('bookings/{id}', [App\Http\Controllers\Admins\AdminController::class, 'deleteBooking'])->name('bookings.delete');

    //foods
    Route::get('all-foods', [App\Http\Controllers\Admins\AdminController::class, 'allFoods'])->name('foods.all');
    Route::get('foods-create', [App\Http\Controllers\Admins\AdminController::class, 'createFood'])->name('foods.create');
    Route::post('foods-create', [App\Http\Controllers\Admins\AdminController::class, 'storeFood'])->name('foods.store');
    Route::get('foods/{id}/edit', [App\Http\Controllers\Admins\AdminController::class, 'editFood'])->name('foods.edit');
    Route::put('foods/{id}', [App\Http\Controllers\Admins\AdminController::class, 'updateFood'])->name('foods.update');
    Route::delete('foods/{id}', [App\Http\Controllers\Admins\AdminController::class, 'deleteFood'])->name('foods.delete');

});