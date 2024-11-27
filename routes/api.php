<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('/auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
});

Route::prefix('city')->group(function () {
    Route::post('/', [CityController::class, 'create']);
    Route::put('/{cityId}', [CityController::class, 'update']);
    Route::get('/{cityId}', [CityController::class, 'showCity']);
    Route::delete('/{cityId}', [CityController::class, 'deleteCity']);
    Route::get('/', [CityController::class, 'showAll']);
});

Route::prefix('/school')->group(function () {
    Route::post('/', [SchoolController::class, 'create']);
    Route::put('/{schoolId}', [SchoolController::class, 'update']);
    Route::get('/', [SchoolController::class, 'showAll']);
    Route::get('/{schoolId}', [SchoolController::class, 'schoolDetail']);
    Route::get('/{schoolId}/class', [SchoolController::class, 'showClasses']);
    Route::get('/{schoolId}/students', [SchoolController::class, 'showStudent']);
    Route::delete('/{schoolId}', [SchoolController::class, 'deleteSchool']);
});

Route::prefix('/student-class')->group(function () {
    Route::post('/', [StudentClassController::class, 'create']);
    Route::put('/{classId}', [StudentClassController::class, 'update']);
    Route::get('/{classId}', [StudentClassController::class, 'showClass']);
    Route::get('/', [StudentClassController::class, 'showAll']);
    Route::delete('/{classId}', [StudentClassController::class, 'deleteClass']);
});

Route::prefix('/student')->group(function () {
    Route::post('/', [StudentController::class, 'create']);
    Route::put('/{studentId}', [StudentController::class, 'update']);
    Route::get('/', [StudentController::class, 'showAll']);
    Route::get('/{studentId}', [StudentController::class, 'showStudent']);
    Route::delete('/{studentId}', [StudentController::class, 'delete']);
});
