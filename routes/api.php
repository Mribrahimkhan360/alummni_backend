<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\User\UserController;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        $user = $request->user()->load('roles.permissions');
        return response()->json([
            'user' => $user,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    });

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index'])->middleware('permission:user-list');
    Route::post('/users', [UserController::class, 'store'])->middleware('permission:user-create');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('permission:user-list');
    Route::post('/users/{user}', [UserController::class, 'update'])->middleware('permission:user-edit');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('permission:user-delete');
    Route::post('/users/{user}/roles', [RoleController::class, 'assignRoleToUser'])->middleware('permission:user-edit');

    Route::get('/roles', [RoleController::class, 'index'])->middleware('permission:role-list');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('permission:role-create');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->middleware('permission:role-list');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('permission:role-edit');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('permission:role-delete');
    Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions'])->middleware('permission:role-edit');

    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('permission:permission-list');
    Route::post('/permissions', [PermissionController::class, 'store'])->middleware('permission:permission-create');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->middleware('permission:permission-list');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->middleware('permission:permission-edit');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('permission:permission-delete');
    
    Route::apiResource('payments', \App\Http\Controllers\Payment\PaymentController::class);

    Route::patch('payments/{payment}/approve', [\App\Http\Controllers\Payment\PaymentController::class, 'approve']);
    Route::patch('payments/{payment}/reject', [\App\Http\Controllers\Payment\PaymentController::class, 'reject']);
});
