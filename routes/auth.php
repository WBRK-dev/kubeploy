<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectResourceController;
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectController::class, "index"])->name('projects');
Route::get('projects/{project}', [ProjectController::class, "show"])->name('project');
Route::get('projects/{project}/{resource}', [ProjectResourceController::class, "show"])->name('project.resource');
Route::put('projects/{project}/{resource}', [ProjectResourceController::class, "save"]);
