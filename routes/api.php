<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\GalleryCategoryController;
use App\Http\Controllers\GalleryController;




// Reset password routes
Route::post('/password/email', [AuthController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);

Route::get('/events/latest', [EventController::class, 'latest']);
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/{id}', [EventController::class, 'show']);
Route::get('/notices/latest', [NoticeController::class, 'latest']);
Route::get('/notices/{id}', [NoticeController::class, 'show']);
Route::get('/blogs/latest', [BlogController::class, 'latest']);
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/alumni', [\App\Http\Controllers\Api\AlumniController::class, 'index']);
Route::get('/alumni/stats', [\App\Http\Controllers\Api\AlumniController::class, 'stats']);
Route::get('/alumni/{id}', [\App\Http\Controllers\Api\AlumniController::class, 'show']);

// about routes
Route::get('/about', [AboutController::class, 'index']);
Route::get('/about/show/{about}', [AboutController::class, 'show']);


Route::get('/testimonials', [TestimonialController::class, 'index']);
Route::get('/testimonials/{id}', [TestimonialController::class, 'show']);

// public gallery routes
Route::get('/gallery-categories', [GalleryCategoryController::class, 'index']);
Route::get('/gallery-categories/{galleryCategory}', [GalleryCategoryController::class, 'show']);
Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/galleries/{gallery}', [GalleryController::class, 'show']);
Route::get('/galleries/by-category/{categoryId}', [GalleryController::class, 'byCategory']);

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
    Route::get('/profile/user',[ProfileController::class,'profile']);
    Route::post('/profile/update',[ProfileController::class,'updateProfile']);


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

    Route::get('/notices', [NoticeController::class, 'index'])->middleware('permission:notice-list');
    Route::post('/notices', [NoticeController::class, 'store'])->middleware('permission:notice-create');
    Route::put('/notices/{id}', [NoticeController::class, 'update'])->middleware('permission:notice-edit');
    Route::delete('/notices/{id}', [NoticeController::class, 'destroy'])->middleware('permission:notice-delete');

    Route::get('/blogs', [BlogController::class, 'index'])->middleware('permission:blog-list');
    Route::post('/blogs', [BlogController::class, 'store'])->middleware('permission:blog-create');
    Route::put('/blogs/{id}', [BlogController::class, 'update'])->middleware('permission:blog-edit');
    Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->middleware('permission:blog-delete');

    Route::get('payments/latest', [\App\Http\Controllers\Payment\PaymentController::class, 'latestPayment']);

    Route::apiResource('payments', \App\Http\Controllers\Payment\PaymentController::class);

    Route::patch('payments/{payment}/approve', [\App\Http\Controllers\Payment\PaymentController::class, 'approve']);
    Route::patch('payments/{payment}/reject', [\App\Http\Controllers\Payment\PaymentController::class, 'reject']);

    Route::get('/events/stats', [EventController::class, 'stats'])->middleware('permission:event-list');
    Route::post('/events', [EventController::class, 'store'])->middleware('permission:event-create');
    Route::put('/events/{id}', [EventController::class, 'update'])->middleware('permission:event-edit');
    Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('permission:event-delete');

    Route::post('/profile/education', [ProfileController::class, 'education']);
    Route::get('/profile/education', [ProfileController::class, 'getEducation']);
    Route::put('/profile/education/{id}', [ProfileController::class, 'updateEducation']);
    Route::delete('/profile/education/{id}', [ProfileController::class, 'deleteEducation']);

    // experience routes
    Route::post('/profile/experience', [ProfileController::class, 'experience']);
    Route::get('/profile/experience', [ProfileController::class, 'getExperience']);
    Route::put('/profile/experience/{id}', [ProfileController::class, 'updateExperience']);
    Route::delete('/profile/experience/{id}', [ProfileController::class, 'deleteExperience']);

    // Achivement
    Route::post('/profile/achievements', [ProfileController::class, 'achievements']);
    Route::get('/profile/achievements', [ProfileController::class, 'getAchievements']);
    Route::put('/profile/achievements/{id}', [ProfileController::class, 'updateAchievements']);
    Route::delete('/profile/achievements/{id}', [ProfileController::class, 'deleteAchievements']);

    // Contact
    Route::post('/profile/contact', [ProfileController::class, 'contact']);
    Route::get('/profile/contact', [ProfileController::class, 'getContact']);
    Route::put('/profile/contact/{id}', [ProfileController::class, 'updateContact']);
    Route::delete('/profile/contact/{id}', [ProfileController::class, 'deleteContact']);

    // about routes
    Route::post('/about/store', [AboutController::class, 'store']);
    Route::put('/about/update/{about}', [AboutController::class, 'update']);
    Route::delete('/about/delete/{about}', [AboutController::class, 'destroy']);

    // testimonial routes
    Route::post('/testimonials/store', [TestimonialController::class, 'store']);
    Route::post('/testimonials/update/{testimonials}', [TestimonialController::class, 'update']);
    Route::delete('/testimonials/delete/{testimonials}', [TestimonialController::class, 'destroy']);

    // gallery-category routes
    Route::post('/gallery-categories', [GalleryCategoryController::class, 'store']);
    Route::put('/gallery-categories/{galleryCategory}', [GalleryCategoryController::class, 'update']);
    Route::delete('/gallery-categories/{galleryCategory}', [GalleryCategoryController::class, 'destroy']);

    // gallery routes
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::post('/galleries/{gallery}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy']);
});
