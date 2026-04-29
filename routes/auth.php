<?php

use App\Http\Controllers\Projects\ProjectController;
use App\Http\Controllers\Projects\ProjectResourceController;
use App\Http\Controllers\Projects\ResourceTypes\ProjectResourceYamlController;
use App\Services\KubernetesClientService;
use Illuminate\Support\Facades\Route;

Route::get('projects', [ProjectController::class, "index"])->name('projects');
Route::post('projects', [ProjectController::class, "store"]);
Route::get('projects/{project}', [ProjectController::class, "show"])->name('project');
Route::put('projects/{project}', [ProjectController::class, "save"]);
Route::delete('projects/{project}', [ProjectController::class, "delete"]);
Route::get('projects/{project}/{resource}', [ProjectResourceController::class, "show"])->name('project.resource');
Route::put('projects/{project}/{resource}', [ProjectResourceController::class, "save"]);
Route::post('projects/{project}/{resource}/yaml/apply', [ProjectResourceYamlController::class, "apply"])->name('project.resource.yaml.apply');
Route::post('projects/{project}/{resource}/yaml/delete', [ProjectResourceYamlController::class, "delete"])->name('project.resource.yaml.delete');

Route::get('test', function () {
    /** @var KubernetesClientService $kubernetesClientService */
    $kubernetesClientService = app(KubernetesClientService::class);
    $client = $kubernetesClientService->createClient(config("kubernetes.kubeconfig"));

    dd($client->nodes()->find());
    dd($client);
});
