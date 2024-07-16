<?php

use App\Http\Controllers\DetailOrderController;
use App\Http\Controllers\DetailPurchaseController;
use App\Http\Controllers\DetailTransferStockController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductUnitController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SignaController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransferStockController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseStockController;
use App\Http\Middleware\EnsureTokenIsValid;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->middleware(EnsureTokenIsValid::class);

Route::prefix('api')->group(function () {
    Route::resource('product', ProductController::class);
    Route::resource('product-unit', ProductUnitController::class);
    Route::resource('product-category', ProductCategoryController::class);
    Route::resource('detail-order', DetailOrderController::class);
    // costume
    Route::get('detail-order/order-id/{orderId}', [DetailOrderController::class, 'showByOrderId']);
    Route::resource('detail-transfer-stock', DetailTransferStockController::class);
    Route::resource('warehouse-stock', WarehouseStockController::class);
    Route::resource('purchase', PurchaseController::class);
    Route::resource('detail-purchase', DetailPurchaseController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('warehouse', WarehouseController::class);
    Route::resource('transfer-stock', TransferStockController::class);
    Route::resource('order', OrderController::class);
    Route::resource('signa', SignaController::class);
    Route::resource('pharmacy', PharmacyController::class);
    Route::resource('patient', PatientController::class);
});
