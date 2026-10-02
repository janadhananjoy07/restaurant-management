<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\StaffAuthController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentController;

use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Admin\StaffRequestController;

use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\FeedbackController;


/*
|--------------------------------------------------------------------------
| Middleware
|--------------------------------------------------------------------------
*/

use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\StaffMiddleware;


/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| CUSTOMER AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/register', [
    AuthController::class,
    'showRegister'
])->name('register');

Route::post('/register', [
    AuthController::class,
    'register'
])->name('register.store');

Route::get('/login', [
    AuthController::class,
    'showLogin'
])->name('login');

Route::post('/login', [
    AuthController::class,
    'login'
])->name('login.store');

Route::post('/logout', [
    AuthController::class,
    'logout'
])->name('logout');


/*
|--------------------------------------------------------------------------
| STAFF AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::prefix('staff')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | STAFF REGISTRATION
    |--------------------------------------------------------------------------
    */

    Route::get('/register', [
        StaffAuthController::class,
        'showRegister'
    ])->name('staff.register');

    Route::post('/register', [
        StaffAuthController::class,
        'register'
    ])->name('staff.register.store');


    /*
    |--------------------------------------------------------------------------
    | STAFF LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get('/login', [
        StaffAuthController::class,
        'showLogin'
    ])->name('staff.login');

    Route::post('/login', [
        StaffAuthController::class,
        'login'
    ])->name('staff.login.store');


    /*
    |--------------------------------------------------------------------------
    | STAFF LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post('/logout', [
        StaffAuthController::class,
        'logout'
    ])->name('staff.logout');
});


/*
|--------------------------------------------------------------------------
| ADMIN AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [
    AdminAuthController::class,
    'showLogin'
])->name('admin.login');

Route::post('/admin/login', [
    AdminAuthController::class,
    'login'
])->name('admin.login.store');

Route::post('/admin/logout', [
    AdminAuthController::class,
    'logout'
])->name('admin.logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware([AdminMiddleware::class])
    ->prefix('admin')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | ADMIN DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/', [
            OrderController::class,
            'adminDashboard'
        ])->name('admin.dashboard');


        /*
        |--------------------------------------------------------------------------
        | STAFF REQUEST MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/staff-requests', [
            StaffRequestController::class,
            'index'
        ])->name('admin.staff-requests.index');

        Route::put('/staff-requests/{id}/approve', [
            StaffRequestController::class,
            'approve'
        ])->name('admin.staff-requests.approve');

        Route::put('/staff-requests/{id}/reject', [
            StaffRequestController::class,
            'reject'
        ])->name('admin.staff-requests.reject');

        Route::put('/staff-requests/{id}/suspend', [
            StaffRequestController::class,
            'suspend'
        ])->name('admin.staff-requests.suspend');

        Route::put('/staff-requests/{id}/reactivate', [
            StaffRequestController::class,
            'reactivate'
        ])->name('admin.staff-requests.reactivate');


        /*
        |--------------------------------------------------------------------------
        | MENU MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/menu', [
            MenuItemController::class,
            'index'
        ])->name('admin.menu');

        Route::get('/menu/create', [
            MenuItemController::class,
            'create'
        ])->name('admin.menu.create');

        Route::post('/menu', [
            MenuItemController::class,
            'store'
        ])->name('admin.menu.store');

        Route::get('/menu/{id}/edit', [
            MenuItemController::class,
            'edit'
        ])->name('admin.menu.edit');

        Route::put('/menu/{id}', [
            MenuItemController::class,
            'update'
        ])->name('admin.menu.update');

        Route::delete('/menu/{id}', [
            MenuItemController::class,
            'destroy'
        ])->name('admin.menu.delete');


        /*
        |--------------------------------------------------------------------------
        | ORDER MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/orders', [
            OrderController::class,
            'adminOrders'
        ])->name('admin.orders');

        Route::put('/orders/{id}/status', [
            OrderController::class,
            'updateStatus'
        ])->name('admin.orders.status');


        /*
        |--------------------------------------------------------------------------
        | RESERVATION MANAGEMENT
        |--------------------------------------------------------------------------
        */

        Route::get('/reservations', [
            UserController::class,
            'adminReservations'
        ])->name('admin.reservations');

        Route::put('/reservations/{id}/status', [
            UserController::class,
            'updateReservationStatus'
        ])->name('admin.reservations.status');


        /*
        |--------------------------------------------------------------------------
        | CUSTOMER FEEDBACK MODERATION
        |--------------------------------------------------------------------------
        */

        Route::get('/feedback', [
            AdminFeedbackController::class,
            'index'
        ])->name('admin.feedback.index');

        Route::patch('/feedback/{id}/status', [
            AdminFeedbackController::class,
            'updateStatus'
        ])->name('admin.feedback.status');
    });


/*
|--------------------------------------------------------------------------
| PROTECTED STAFF ROUTES
|--------------------------------------------------------------------------
|
| IMPORTANT:
| There is ONLY ONE staff protected group.
|
| Staff can:
| - See available orders
| - Claim orders
| - Update their own orders
| - Collect cash
| - Collect UPI
| - Start Cashfree online payment during delivery
| - Complete delivered orders
|
|--------------------------------------------------------------------------
*/

Route::middleware([StaffMiddleware::class])
    ->prefix('staff')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | STAFF DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/', [
            StaffController::class,
            'dashboard'
        ])->name('staff.dashboard');


        /*
        |--------------------------------------------------------------------------
        | STAFF ORDERS
        |--------------------------------------------------------------------------
        */

        Route::get('/orders', [
            StaffController::class,
            'dashboard'
        ])->name('staff.orders');


        /*
        |--------------------------------------------------------------------------
        | CLAIM ORDER
        |--------------------------------------------------------------------------
        */

        Route::post('/orders/{id}/claim', [
            StaffController::class,
            'claimOrder'
        ])->name('staff.orders.claim');


        /*
        |--------------------------------------------------------------------------
        | ONLINE PAYMENT DURING DELIVERY
        |--------------------------------------------------------------------------
        |
        | Example:
        |
        | /staff/orders/25/payment/online
        |
        | This opens Cashfree checkout for the delivery partner.
        |
        |--------------------------------------------------------------------------
        */

        Route::get('/orders/{id}/payment/online', [
            PaymentController::class,
            'staffOnlinePayment'
        ])->name('staff.payment.online');


        /*
        |--------------------------------------------------------------------------
        | UPDATE ORDER STATUS
        |--------------------------------------------------------------------------
        */

        Route::put('/orders/{id}/status', [
            StaffController::class,
            'updateStatus'
        ])->name('staff.orders.status');
    });


/*
|--------------------------------------------------------------------------
| PROTECTED CUSTOMER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware([AuthMiddleware::class])
    ->prefix('user')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/dashboard', [
            UserController::class,
            'dashboard'
        ])->name('user.dashboard');


        /*
        |--------------------------------------------------------------------------
        | MENU
        |--------------------------------------------------------------------------
        */

        Route::get('/menu', [
            UserController::class,
            'menu'
        ])->name('user.menu');


        /*
        |--------------------------------------------------------------------------
        | CART
        |--------------------------------------------------------------------------
        */

        Route::get('/cart', [
            CartController::class,
            'index'
        ])->name('user.cart');

        Route::post('/cart/{id}', [
            CartController::class,
            'add'
        ])->name('user.cart.add');

        Route::put('/cart/{id}', [
            CartController::class,
            'update'
        ])->name('user.cart.update');

        Route::delete('/cart/{id}', [
            CartController::class,
            'remove'
        ])->name('user.cart.remove');


        /*
        |--------------------------------------------------------------------------
        | CHECKOUT
        |--------------------------------------------------------------------------
        */

        Route::get('/checkout', [
            OrderController::class,
            'checkout'
        ])->name('user.checkout');


        /*
        |--------------------------------------------------------------------------
        | PLACE ORDER
        |--------------------------------------------------------------------------
        */

        Route::post('/order', [
            OrderController::class,
            'placeOrder'
        ])->name('user.order.place');


        /*
        |--------------------------------------------------------------------------
        | USER ORDERS
        |--------------------------------------------------------------------------
        */

        Route::get('/orders', [
            OrderController::class,
            'orders'
        ])->name('user.orders');


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [
            UserController::class,
            'profile'
        ])->name('user.profile');

        Route::put('/profile', [
            UserController::class,
            'updateProfile'
        ])->name('user.profile.update');


        /*
        |--------------------------------------------------------------------------
        | TABLE BOOKING
        |--------------------------------------------------------------------------
        */

        Route::get('/book-table', [
            UserController::class,
            'showBookTable'
        ])->name('user.book-table');

        Route::post('/book-table', [
            UserController::class,
            'bookTable'
        ])->name('user.book-table.store');


        /*
        |--------------------------------------------------------------------------
        | RESERVATIONS
        |--------------------------------------------------------------------------
        */

        Route::get('/reservations', [
            UserController::class,
            'reservations'
        ])->name('user.reservations');

        Route::put('/reservations/{id}/cancel', [
            UserController::class,
            'cancelReservation'
        ])->name('user.reservations.cancel');
    });


/*
|--------------------------------------------------------------------------
| CUSTOMER FEEDBACK
|--------------------------------------------------------------------------
*/

Route::middleware([AuthMiddleware::class])
    ->group(function () {

        Route::get('/feedback', [
            FeedbackController::class,
            'index'
        ])->name('feedback');

        Route::post('/feedback', [
            FeedbackController::class,
            'store'
        ])->name('feedback.store');

        Route::post('/feedback/{order}/dismiss', [
            FeedbackController::class,
            'dismiss'
        ])->name('feedback.dismiss');
    });


/*
|--------------------------------------------------------------------------
| PUBLIC CUSTOMER REVIEWS
|--------------------------------------------------------------------------
*/

Route::get('/reviews', [
    ReviewsController::class,
    'index'
])->name('reviews.index');


/*
|--------------------------------------------------------------------------
| CUSTOMER CASHFREE PAYMENT
|--------------------------------------------------------------------------
*/

Route::middleware([AuthMiddleware::class])
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | CREATE CUSTOMER ONLINE PAYMENT
        |--------------------------------------------------------------------------
        */

        Route::post('/payment/cashfree/create', [
            PaymentController::class,
            'create'
        ])->name('payment.cashfree.create');


        /*
        |--------------------------------------------------------------------------
        | CASHFREE RETURN
        |--------------------------------------------------------------------------
        */

        Route::get('/payment/cashfree/return', [
            PaymentController::class,
            'return'
        ])->name('payment.cashfree.return');


        /*
        |--------------------------------------------------------------------------
        | CASHFREE WEBHOOK
        |--------------------------------------------------------------------------
        */

        Route::post('/payment/cashfree/webhook', [
            PaymentController::class,
            'webhook'
        ])->name('payment.cashfree.webhook');
    });

