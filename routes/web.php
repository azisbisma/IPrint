<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Shop\IndexController;
use App\Http\Controllers\Auth\Admin\LoginController;
use Illuminate\Support\Facades\Artisan;

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


Route::get('/storage-link', function() {
    Artisan::call('storage:link');
    return 'Storage linked succesfully';
});

// Shop Page

Route::get('/', [IndexController::class, 'home'])->name('home');
Route::get('/product-cat/{slug}', [IndexController::class, 'productCat'])->name('product-cat');
Route::get('/product-detail/{slug}', [IndexController::class, 'productDetail'])->name('product-detail');
//Login Section
Route::get('/user/login', [IndexController::class, 'userLogin'])->name('user.login');
Route::post('/user/submitLog', [IndexController::class, 'userSubmitLog'])->name('login.submit');
//Forgot Password Section
Route::get('/forgot-password', [IndexController::class, 'showForgotPasswordForm'])->name('password.form');
Route::post('/forgot-password', [IndexController::class, 'sendResetLink'])->name('send.email');
Route::get('/reset-password/{token}', [IndexController::class, 'showResetPasswordForm'])->name('reset.form');
Route::post('/reset-password/{token}', [IndexController::class, 'resetPassword'])->name('pass.reset');

//Register Section
Route::post('/user/submitReg', [IndexController::class, 'userSubmitReg'])->name('register.submit');
Route::get('/user/register', [IndexController::class, 'userRegister'])->name('user.register');
//Log Out Section
Route::get('/user/logout', [IndexController::class, 'userLogout'])->name('user.logout');
//Search Section
Route::get('/search', [IndexController::class, 'search'])->name('search');

Route::get('/product', [IndexController::class, 'productGrids'])->name('products');
Route::get('/product-list', [IndexController::class, 'productLists'])->name('product-lists');



// Cart section
    Route::get('/add-to-cart/{slug}', [CartController::class, 'addToCart'])->name('add-to-cart')->middleware('customer');
    Route::post('/add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-to-cart')->middleware('customer');
    Route::get('cart-delete/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');
    Route::post('cart-update', [CartController::class, 'cartUpdate'])->name('cart.update');
    Route::get('/cart', function () {return view('shop.pages.cart');})->name('cart')->middleware('customer');
    
// Coupon
    Route::post('/cart', [CartController::class, 'couponStore'])->name('coupon-store')->middleware('customer');
// Order Section
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('customer');
    Route::post('/order', [CheckoutController::class, 'order'])->name('order')->middleware('customer');
    Route::post('/order/pay/{id}', [OrderController::class, 'pay'])->name('order.pay')->middleware('customer');
    Route::get('/order-confirmation/{order}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
    




// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes(['register'=>false]);

//Admin Login
Route::prefix('admin')->group(function () {
    Route::get('/login',[LoginController::class, 'showLoginForm'])->name('login-form-admin');
    Route::post('/login',[LoginController::class, 'login'])->name('login-admin');
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');

});

//Admin dashboard
Route::group(['prefix'=>'admin','middleware'=>['admin']],function(){
    Route::get('/', [AdminController::class, 'admin'])->name('admin');
    Route::get('/myaccount', [AdminController::class, 'adminSetting'])->name('admin-setting');
    Route::post('/editProfile{id}', [AdminController::class, 'adminEdit'])->name('admin-edit');
    Route::post('/changepass', [AdminController::class, 'adminPass'])->name('admin-pass');
    Route::get('admin/monthly-income', [OrderController::class, 'getMonthlyIncomeForYear'])->name('monthly.income');


// Banner Section
    Route::resource('/banner', BannerController::class);

// Category Section
    Route::resource('/category', CategoryController::class);

// Brand Section
    Route::resource('/brand', BrandController::class);

// Product Section
    Route::resource('/product', ProductController::class);

// Coupon Section
    Route::resource('/coupon', CouponController::class);

// Order Section
    Route::resource('/order', OrderController::class);
    Route::post('order-status',[OrderController::class, 'orderStatus'])->name('order.status');
    Route::get('admin/orders/report/download', [OrderController::class, 'downloadReport'])->name('orders.report.download');
    Route::get('/order/{id}/download-pdf', [OrderController::class, 'downloadPDF'])->name('order.downloadPDF');
    Route::delete('/order/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('orders/{id}/send-invoice', [OrderController::class, 'sendInvoiceByEmail'])->name('orders.sendInvoice');




});

//Customer dashboard
Route::group(['prefix'=>'customer', 'middleware' => ['auth', 'customer']],function(){
    Route::get('/dashboard', [IndexController::class, 'customerDashboard'])->name('customer.dashboard');
    Route::get('/setting', [IndexController::class, 'customerSetting'])->name('customer.setting');
    Route::get('/order/history', [IndexController::class, 'customerOrder'])->name('customer.order');
    Route::post('/order/cancel/{id}', [IndexController::class, 'cancelOrder'])->name('order.cancel');
    Route::post('/order/confirm/{id}', [IndexController::class, 'confirmOrder'])->name('order.confirm');
    Route::post('/editProfile{id}', [IndexController::class, 'editProfile'])->name('edit.profile');
    Route::post('/changePass', [IndexController::class, 'changePass'])->name('change.pass');

});
