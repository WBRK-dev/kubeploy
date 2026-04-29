<?php

namespace App\Http\Controllers\Projects;

use App\Enums\ProjectResourceType;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ProjectResourceController extends Controller
{
    public function show(string $currentTeam, Project $project, ProjectResource $resource): Response
    {
        $resource->loadType();

        return inertia("projects/resources/Show", [
            "project" => $project,
            "resource" => $resource,
        ]);
    }

    public function save(Request $request, string $currentTeam, Project $project, ProjectResource $resource): RedirectResponse
    {
        switch ($resource->type) {
            case (ProjectResourceType::Yaml->value):
                $body = $request->validate([
                    "yaml" => "required|string",
                ]);
                $resource->yamlTrait->yaml = $body['yaml'];
                $resource->yamlTrait->save();
                break;
        }

        return back();
    }

    public function apply(string $currentTeam, Project $project, ProjectResource $resource): JsonResponse
    {
        if ($resource->type !== ProjectResourceType::Yaml->value) {
            return response()->json(['message' => 'Incorrect resource type'], 400);
        }

        $client = $this->kubernetesClientService->createClient(config('kubernetes.kubeconfig'));
        $this->kubernetesSmartPatchService->setClient($client);
        $this->kubernetesSmartPatchService->patch($resource->yamlTrait->yaml);

        return response()->json(['message' => 'Applied patch']);
    }
}
