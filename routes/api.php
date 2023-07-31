<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FarmController;
use App\Http\Controllers\TurbineController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ComponentTypeController;
use App\Http\Controllers\GradeTypeController;

Route::prefix('farms')->group(function () {
    Route::get('/', [FarmController::class, 'index']);
    Route::get('/{farmID}', [FarmController::class, 'show']);
    Route::get('/{farmID}/turbines', [TurbineController::class, 'getTurbinesByFarm']);
});

Route::prefix('turbines')->group(function () {
    Route::get('/', [TurbineController::class, 'index']);
    Route::get('/{turbineID}', [TurbineController::class, 'show']);
    Route::get('/{turbineID}/components', [ComponentController::class, 'getComponentsByTurbine']);
    Route::get('/{turbineID}/inspections', [InspectionController::class, 'getInspectionsByTurbine']);
});

Route::get('/components', [ComponentController::class, 'index']);

Route::prefix('component-types')->group(function () {
    Route::get('/', [ComponentTypeController::class, 'index']);
    Route::get('/{componentTypeID}', [ComponentTypeController::class, 'show']);
});

Route::prefix('inspections')->group(function () {
    Route::get('/', [InspectionController::class, 'index']);
    Route::get('/{inspectionID}', [InspectionController::class, 'show']);
    Route::get('/{inspectionID}/grades', [GradeController::class, 'getGradesByInspection']);
});

Route::prefix('grades')->group(function () {
    Route::get('/', [GradeController::class, 'index']);
    Route::get('/{gradeID}', [GradeController::class, 'show']);
});

Route::prefix('grade-types')->group(function () {
    Route::get('/', [GradeTypeController::class, 'index']);
    Route::get('/{gradeTypeID}', [GradeTypeController::class, 'show']);
});
