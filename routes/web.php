<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
Route::middleware(['auth'])->group(function () {
    // page showing product table + AJAX frontend
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    // API-style endpoints for AJAX (all respond JSON)
    Route::post('/products', [ProductController::class, 'store'])->name('products.store')->middleware('role:admin');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('role:admin|employee');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update')->middleware('role:admin');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy')->middleware('role:admin');
});






// Public Routes
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/', [AuthController::class, 'register']);

// // Protected Routes (Sanctum + Role Based)
// Route::middleware('auth:sanctum')->group(function () {

//     // Only Admin
//     Route::middleware('role:admin')->group(function () {
//         Route::get('/admin/dashboard', function () {
//             return response()->json(['message' => 'Welcome Admin']);
//         });

//         Route::apiResource('/products', ProductController::class);
//     });

//     // Only Employee
//     Route::middleware('role:employee')->group(function () {
//         Route::get('/employee/dashboard', function () {
//             return response()->json(['message' => 'Welcome Employee']);
//         });

//         Route::get('/products', [ProductController::class, 'index']);
//     });

//     // Common logout
//     Route::post('/logout', [AuthController::class, 'logout']);
// });

