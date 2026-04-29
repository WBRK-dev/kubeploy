<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectResourceController;
use App\Services\KubernetesClientService;
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectController::class, "index"])->name('projects');
Route::get('projects/{project}', [ProjectController::class, "show"])->name('project');
Route::get('projects/{project}/{resource}', [ProjectResourceController::class, "show"])->name('project.resource');
Route::put('projects/{project}/{resource}', [ProjectResourceController::class, "save"]);

Route::get('test', function () {
    /** @var KubernetesClientService $kubernetesClientService */
    $kubernetesClientService = app(KubernetesClientService::class);
    $client = $kubernetesClientService->createClient(config("kubernetes.kubeconfig"));

    dd($client->nodes()->find());
    dd($client);
});
