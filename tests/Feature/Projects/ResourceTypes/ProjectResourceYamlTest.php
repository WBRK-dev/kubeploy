<?php

use App\Enums\ProjectResourceType;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\ProjectResourceYaml;
use App\Models\User;

test('users can save yaml resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Yaml->value,
    ]);
    $yaml = ProjectResourceYaml::factory()->create(['project_resource_id' => $resource->id]);
    $saveData = [
        'yaml' => "apiVersion: v1\nkind: ConfigMap\nmetadata:\n  name: updated\n  namespace: default\ndata:\n  key: newvalue",
    ];

    $response = $this->actingAs($user)->put("projects/{$project->id}/{$resource->id}/yaml", $saveData);

    $response->assertRedirect();
    $yaml->refresh();
    expect($yaml->yaml)->toContain('name: updated');
});

test('yaml save validates input', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['team_id' => $user->currentTeam->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Yaml->value,
    ]);
    ProjectResourceYaml::factory()->create(['project_resource_id' => $resource->id]);

    // Missing yaml
    $response = $this->actingAs($user)->put("projects/{$project->id}/{$resource->id}/yaml", []);
    $response->assertSessionHasErrors('yaml');
});

test('users can apply yaml patch to kubernetes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Yaml->value,
    ]);
    ProjectResourceYaml::factory()->create(['project_resource_id' => $resource->id]);

    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/yaml/apply");

    $response->assertJson(['message' => 'Applied patch']);
});

test('apply fails for non-yaml resources', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);

    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/yaml/apply");

    $response->assertJson(['message' => 'Incorrect resource type'], 400);
});

test('users can delete yaml resource from kubernetes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Yaml->value,
    ]);
    ProjectResourceYaml::factory()->create(['project_resource_id' => $resource->id]);

    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/yaml/delete");

    $response->assertJson(['message' => 'Deleted']);
});

test('delete fails for non-yaml resources', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);

    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/yaml/delete");

    $response->assertJson(['message' => 'Incorrect resource type'], 400);
});
