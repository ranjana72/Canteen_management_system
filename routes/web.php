<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EsewaController;
use App\Http\Controllers\NotificationController;
use App\Models\MenuItem;

Route::get('/', function () {
    return view('landing', [
        'previewItems' => MenuItem::where('is_available', true)->latest()->take(3)->get(),
    ]);
})->name('landing');

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        switch (auth()->user()->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'kitchen':
                return redirect()->route('kitchen.dashboard');
            default:
                return redirect()->route('student.dashboard');
        }
    })->name('dashboard');

    Route::get('/today-menu', [MenuItemController::class, 'today'])->name('menu.today');

    Route::get('/notifications/active', [NotificationController::class, 'active'])
        ->name('notifications.active');

    /*
    |--------------------------------------------------------------------------
    | STUDENT
    |--------------------------------------------------------------------------
    */
    Route::prefix('student')
        ->name('student.')
        ->middleware('role:student')
        ->group(function () {

            // ✅ UPDATED — now uses StudentController with real DB data
            Route::get('/dashboard', [StudentController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/menu', [MenuItemController::class, 'index'])
                ->name('menu.index');

            Route::get('/menu/{menuItem}', [MenuItemController::class, 'show'])
                ->name('menu.show');

            Route::resource('orders', OrderController::class)
                ->only(['index', 'create', 'store', 'show']);

            // Student self-service edit/cancel — pending orders only
            Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])
                ->name('orders.edit');

            Route::put('/orders/{order}', [OrderController::class, 'studentUpdate'])
                ->name('orders.update');

            Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])
                ->name('orders.cancel');

            Route::resource('payments', PaymentController::class)
                ->only(['index', 'create', 'store', 'show']);

            Route::get('/payments/esewa/initiate/{order}', [EsewaController::class, 'initiate'])
                ->name('payments.esewa.initiate');

            Route::get('/payments/esewa/success', [EsewaController::class, 'success'])
                ->name('payments.esewa.success');

            Route::get('/payments/esewa/failure', [EsewaController::class, 'failure'])
                ->name('payments.esewa.failure');

            Route::get('/orders/{order}/feedback', [FeedbackController::class, 'create'])
                ->name('orders.feedback.create');

            Route::post('/orders/{order}/feedback', [FeedbackController::class, 'store'])
                ->name('orders.feedback.store');

            Route::get('/feedback', [FeedbackController::class, 'studentIndex'])
                ->name('feedback.index');

            Route::get('/ratings', [FeedbackController::class, 'studentRatings'])
                ->name('ratings.index');

            Route::get('/notifications', [NotificationController::class, 'studentIndex'])
                ->name('notifications.index');

        });

    /*
    |--------------------------------------------------------------------------
    | KITCHEN
    |--------------------------------------------------------------------------
    */
    Route::prefix('kitchen')
        ->name('kitchen.')
        ->middleware('role:kitchen')
        ->group(function () {

            Route::get('/dashboard', [KitchenController::class, 'dashboard'])
                ->name('dashboard');

            Route::get('/orders', [KitchenController::class, 'orders'])
                ->name('orders.index');

            Route::patch('/orders/{order}/confirm', [KitchenController::class, 'confirm'])
                ->name('confirm');

            Route::patch('/orders/{order}/ready', [KitchenController::class, 'markReady'])
                ->name('ready');

            Route::patch('/orders/{order}/delivered', [KitchenController::class, 'markDelivered'])
                ->name('delivered');

            Route::patch('/menu-items/{menuItem}/toggle-stock', [MenuItemController::class, 'toggleStock'])
                ->name('menu-items.toggle-stock');

            Route::resource('menu-items', MenuItemController::class);

            Route::get('/payments', [KitchenController::class, 'payments'])
                ->name('payments.index');

            Route::get('/payments/{payment}', [KitchenController::class, 'showPayment'])
                ->name('payments.show');

            Route::get('/feedback', [FeedbackController::class, 'index'])
                ->name('feedback.index');

            Route::get('/ratings', [FeedbackController::class, 'ratings'])
                ->name('ratings.index');

            Route::get('/reports/daily', [ReportController::class, 'daily'])
                ->name('reports.daily');

            Route::get('/reports/sales', [ReportController::class, 'sales'])
                ->name('reports.sales');

            Route::get('/reports/items', [ReportController::class, 'items'])
                ->name('reports.items');

            Route::get('/notifications', [NotificationController::class, 'index'])
                ->name('notifications.index');

            Route::get('/notifications/data', [NotificationController::class, 'data'])
                ->name('notifications.data');

            Route::post('/notifications', [NotificationController::class, 'store'])
                ->name('notifications.store');

            Route::put('/notifications/{notification}', [NotificationController::class, 'update'])
                ->name('notifications.update');

            Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
                ->name('notifications.destroy');

        });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {

            Route::view('/dashboard', 'admin.dashboard')
                ->name('dashboard');

            Route::resource('users', UserController::class);

            Route::resource('orders', OrderController::class)
                ->only(['index', 'show', 'update']);

            Route::resource('payments', PaymentController::class);

            Route::patch('/payments/{payment}/mark-paid', [PaymentController::class, 'update'])
                ->name('payments.markPaid');

            Route::get('/notifications', [NotificationController::class, 'index'])
                ->name('notifications.index');

            Route::get('/notifications/data', [NotificationController::class, 'data'])
                ->name('notifications.data');

            Route::post('/notifications', [NotificationController::class, 'store'])
                ->name('notifications.store');

            Route::put('/notifications/{notification}', [NotificationController::class, 'update'])
                ->name('notifications.update');

            Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])
                ->name('notifications.destroy');

        });

});