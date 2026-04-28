<?php

namespace App\Http\Controllers;

use App\Enums\ProjectResourceType;
use App\Models\Project;
use App\Models\ProjectResource;
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
}
