<?php

namespace App\Http\Controllers\Projects\ResourceTypes;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Services\ApplicationResourceService;
use App\Services\KubernetesClientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectResourceApplicationController extends Controller
{
    public function __construct(
        protected KubernetesClientService $kubernetesClientService,
        protected ApplicationResourceService $applicationResourceService,
    ) { }

    public function save(Request $request, string $currentTeam, Project $project, ProjectResource $resource): RedirectResponse
    {
        $body = $request->validate([
            'deployment' => 'nullable|array',
            'environment' => 'nullable|array',
            'domains' => 'nullable|array',
            'ports' => 'nullable|array',
        ]);

        if (!empty($body['deployment'])) {
            $resource->applicationTrait->deployment = $body['deployment'];
        }
        $resource->applicationTrait->save();

        return back();
    }

    public function deploy(string $currentTeam, Project $project, ProjectResource $resource): JsonResponse
    {
        $kubeconfig = config('kubernetes.kubeconfig');
        $this->applicationResourceService
            ->setClient($this->kubernetesClientService->createClient($kubeconfig))
            ->deploy($resource);

        return response()->json(['message' => 'Applied patch']);
    }
}
