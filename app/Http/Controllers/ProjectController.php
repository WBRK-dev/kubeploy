<?php

namespace App\Http\Controllers;

use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepository $projectRepository,
    ) { }

    public function index(Request $request): Response
    {
        $user = $request->user();

        return inertia("projects/Index", [
            "projects" => $user->currentTeam->projects,
        ]);
    }

    public function show(Request $request, string $team, int $project): Response
    {
        return inertia("projects/Show", [
            "project" => $this->projectRepository->getById($project, $team),
        ]);
    }
}
