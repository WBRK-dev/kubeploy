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
use Str;

class ProjectResourceApplicationController extends Controller
{
    public function __construct(
        protected KubernetesClientService $kubernetesClientService,
        protected ApplicationResourceService $applicationResourceService,
    ) {}

    public function save(Request $request, string $currentTeam, Project $project, ProjectResource $resource): RedirectResponse
    {
        $body = $request->validate([
            'deployment' => 'nullable|array',
            'environment' => 'nullable|array',
            'domains' => 'nullable|array',
            'ports' => 'nullable|array',
        ]);

        if (! empty($body['deployment'])) {
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

    public function newPort(Request $request, string $currentTeam, Project $project, ProjectResource $resource): RedirectResponse
    {
        $body = $request->validate([
            'hostPort' => 'required|integer|min:1|max:65535',
            'containerPort' => 'required|integer|min:1|max:65535',
        ]);

        $body['selector'] = Str::slug(Str::random(8));

        $ports = $resource->applicationTrait->ports;
        $ports[] = $body;
        $resource->applicationTrait->ports = $ports;

        $resource->applicationTrait->save();

        return back();
    }

    public function updatePort(Request $request, string $currentTeam, Project $project, ProjectResource $resource): RedirectResponse
    {
        $body = $request->validate([
            'selector' => 'required|string|max:8',
            'hostPort' => 'required|integer|min:1|max:65535',
            'containerPort' => 'required|integer|min:1|max:65535',
        ]);

        $ports = $resource->applicationTrait->ports;
        foreach ($ports as &$port) {
            if ($port['selector'] !== $body['selector']) {
                continue;
            }
            $port['hostPort'] = $body['hostPort'];
            $port['containerPort'] = $body['containerPort'];
            break;
        }
        $resource->applicationTrait->ports = $ports;

        $resource->applicationTrait->save();

        return back();
    }

    public function deletePort(Request $request, string $currentTeam, Project $project, ProjectResource $resource): RedirectResponse
    {
        $body = $request->validate([
            'selector' => 'required|string|max:8',
        ]);

        $ports = $resource->applicationTrait->ports;
        $ports = array_filter($ports, fn ($port) => $port['selector'] !== $body['selector']);
        $resource->applicationTrait->ports = $ports;

        $resource->applicationTrait->save();

        return back();
    }
}
