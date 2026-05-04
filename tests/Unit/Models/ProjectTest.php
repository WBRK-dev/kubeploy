<?php

use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\Team;

test('project belongs to team', function () {
    $team = Team::factory()->create();
    $project = Project::factory()->create(['team_id' => $team->id]);

    expect($project->team)->toBeInstanceOf(Team::class);
    expect($project->team->id)->toBe($team->id);
});

test('project has many resources', function () {
    $project = Project::factory()->create();
    $resources = ProjectResource::factory()->count(3)->create(['project_id' => $project->id]);

    expect($project->resources)->toHaveCount(3);
    expect($project->resources->first())->toBeInstanceOf(ProjectResource::class);
});
