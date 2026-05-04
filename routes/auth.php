<?php

use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ProjectResourceController;
use App\Http\Controllers\Projects\ResourceTypes\ProjectResourceApplicationController;
use App\Http\Controllers\Projects\ResourceTypes\ProjectResourceYamlController;
use App\Services\KubernetesClientService;
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectController::class, "index"])->name('projects');
Route::post('projects', [ProjectController::class, "store"]);

Route::get('projects/{project}', [ProjectController::class, "show"])->name('project');
Route::post('projects/{project}', [ProjectResourceController::class, "store"]);
Route::put('projects/{project}', [ProjectController::class, "save"]);
Route::delete('projects/{project}', [ProjectController::class, "delete"]);

Route::get('projects/{project}/{resource}', [ProjectResourceController::class, "show"])->name('project.resource');
Route::put('projects/{project}/{resource}', [ProjectResourceController::class, "save"]);
Route::delete('projects/{project}/{resource}', [ProjectResourceController::class, "delete"]);

Route::put('projects/{project}/{resource}/application', [ProjectResourceApplicationController::class, "save"])->name('project.resource.application');
Route::post('projects/{project}/{resource}/application/deploy', [ProjectResourceApplicationController::class, "deploy"])->name('project.resource.application.deploy');
Route::post('projects/{project}/{resource}/application/ports', [ProjectResourceApplicationController::class, "newPort"])->name('project.resource.application.ports');
Route::put('projects/{project}/{resource}/application/ports', [ProjectResourceApplicationController::class, "updatePort"]);
Route::delete('projects/{project}/{resource}/application/ports', [ProjectResourceApplicationController::class, "deletePort"]);

Route::put('projects/{project}/{resource}/yaml', [ProjectResourceYamlController::class, "save"])->name('project.resource.yaml');
Route::post('projects/{project}/{resource}/yaml/apply', [ProjectResourceYamlController::class, "apply"])->name('project.resource.yaml.apply');
Route::post('projects/{project}/{resource}/yaml/delete', [ProjectResourceYamlController::class, "delete"])->name('project.resource.yaml.delete');

Route::get('test', function () {
    /** @var KubernetesClientService $kubernetesClientService */
    $kubernetesClientService = app(KubernetesClientService::class);
    $client = $kubernetesClientService->createClient(config("kubernetes.kubeconfig"));

    dd($client->nodes()->find());
    dd($client);
});
