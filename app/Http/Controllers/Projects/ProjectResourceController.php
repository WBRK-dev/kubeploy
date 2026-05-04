<?php

namespace App\Http\Controllers\Projects;

use App\Enums\ProjectResourceType;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Repositories\ProjectResourceRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Response;

class ProjectResourceController extends Controller
{
    public function __construct(
        protected ProjectResourceRepository $projectResourceRepository,
    ) {}

    public function show(string $currentTeam, Project $project, ProjectResource $resource): Response
    {
        $resource->loadType();

        return inertia('projects/resources/Show', [
            'project' => $project,
            'resource' => $resource,
        ]);
    }

    public function save(Request $request, string $currentTeam, Project $project, ProjectResource $resource): RedirectResponse
    {
        $body = $request->validate([
            'name' => 'required|string|min:1|max:20',
        ]);

        $resource->name = $body['name'];
        $this->projectResourceRepository->update($resource);

        return back();
    }

    public function store(Request $request, string $currentTeam, Project $project): RedirectResponse
    {
        $body = $request->validate([
            'name' => 'required|string|min:1|max:20',
            'type' => ['required', Rule::enum(ProjectResourceType::class)],
        ]);

        /** @var Team $team */
        $team = $request->user()->currentTeam;
        $this->projectResourceRepository->create($body['name'], $body['type'], $project->id);

        return back();
    }

    public function delete(Request $request, string $currentTeam, int $project, int $resource): RedirectResponse
    {
        $this->projectResourceRepository->delete($resource);

        return back();
    }
}
