<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectResource;
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
}
