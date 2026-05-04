<?php

namespace App\Http\Controllers\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Team;
use App\Repositories\ProjectRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepository $projectRepository,
    ) {}

    public function index(Request $request): Response
    {
        $user = $request->user();

        return inertia('projects/Index', [
            'projects' => $user->currentTeam->projects,
        ]);
    }

    public function show(Request $request, string $team, int $project): Response
    {
        return inertia('projects/Show', [
            'project' => $this->projectRepository->getById($project, $team),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $body = $request->validate([
            'name' => 'required|string|min:1|max:20',
        ]);

        /** @var Team $team */
        $team = $request->user()->currentTeam;
        $this->projectRepository->create($body['name'], $team->id);

        return back();
    }

    public function delete(string $currentTeam, int $project): RedirectResponse
    {
        $this->projectRepository->delete($project);

        return back();
    }

    public function save(Request $request, string $currentTeam, Project $project): RedirectResponse
    {
        $body = $request->validate([
            'name' => 'required|string|min:1|max:20',
        ]);

        $project->name = $body['name'];
        $this->projectRepository->update($project);

        return back();
    }
}
