<?php

use Illuminate\Support\Facades\Route;
// Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\PatternSerialController;

Route::group(['middleware' => ['checkLogin']], function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/home', [HomeController::class, 'index']);

    // User
    Route::get('/profile', [UserController::class, 'viewUserDetails']);
    Route::post('/user/update', [UserController::class, 'updateUserDetails']);
    // Fee
    Route::get('/fee', [FeeController::class, 'index']);
    Route::post('/fee', [FeeController::class, 'createFee']);
    Route::group(['middleware' => ['checkReceiptSetting']], function () {
        // Receipt
        Route::get('/receipt', [ReceiptController::class,'index']);
        Route::get('/receipt/create', [ReceiptController::class,'showCreateReceipt']);
        Route::post('/receipt/create', [ReceiptController::class,'createReceipt']);
        Route::post('/receipt/search', [ReceiptController::class,'searchReceipt']);
        // Danh cho view giao diện điều chỉnh biên lai
        Route::get('/receipt/adjust/{fkey_receipt}', [ReceiptController::class,'showAdjustReceipt']);
        Route::post('/receipt/adjust', [ReceiptController::class,'adjustReceipt']);
        Route::get('/receipt/replace/{fkey_receipt}', [ReceiptController::class,'showReplaceReceipt']);
        Route::post('/receipt/replace', [ReceiptController::class,'replaceReceipt']);
        // // // Dành cho view giao diện biên lai trước khi in
        Route::get('/receipt/{fkey_receipt}', [ReceiptController::class,'getDataReceipt']);
    });
    // Auth
    Route::get('/logout', [AuthController::class, 'logout']);
    // Organization / Department
    Route::get('/department', [OrganizationController::class, 'listDepartment']);
    Route::get('/department/revenue', [OrganizationController::class, 'showRevenueDepartment']);
    Route::post('/department/revenue', [OrganizationController::class, 'revenueDepartment']);
    Route::get('/department/create', [OrganizationController::class, 'showFormCreateDepartment']);
    Route::post('/department/create', [OrganizationController::class, 'createDepartment']);
    // Serial Pattern
    Route::get('/pattern-serial', [PatternSerialController::class, 'index']);
    Route::post('/pattern/create', [PatternSerialController::class, 'createPattern']);
    Route::post('/serial/create', [PatternSerialController::class, 'createSerrial']);
});
Route::group(['middleware' => ['disallowLogin']], function () {
    // Auth
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);
});
Route::group(['middleware' => ['checkIsAdmin']], function () {
    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::get('/admin/home', [AdminController::class, 'index']);
    Route::get('/admin', [AdminController::class, 'index']);
    
    Route::get('/admin/user', [AdminController::class, 'listUser']);
    Route::post('/admin/user/create', [AdminController::class, 'createUser']);
    Route::get('/admin/lock-user/{user_id}', [UserController::class, 'lockUser']);
    Route::get('/admin/unlock-user/{user_id}', [UserController::class, 'unlockUser']);
    Route::get('/admin/reset-pasword-user/{user_id}', [UserController::class, 'resetPasswordUser']);
});
// Tra cứu biên lai dành cho khách hàng nhận được biên nhận
Route::get('/receipt/lookup/{fkey_receipt}', [ReceiptController::class,'lookupReceipt']);
// Tải về biên lai
Route::get('/receipt/download/{fkey_receipt}', [ReceiptController::class,'downloadReceipt']);