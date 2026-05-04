<?php

use App\Enums\ProjectResourceType;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\ProjectResourceApplication;
use App\Models\User;

test('users can save application resource configuration', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);
    $application = ProjectResourceApplication::factory()->create(['project_resource_id' => $resource->id]);
    $saveData = [
        'deployment' => ['image' => 'nginx:1.20'],
        'environment' => ['KEY' => 'value'],
        'domains' => ['test.com'],
        'ports' => [['hostPort' => 8080, 'containerPort' => 80]],
    ];

    $response = $this->actingAs($user)->put("projects/{$project->id}/{$resource->id}/application", $saveData);

    $response->assertRedirect();
    $application->refresh();
    expect($application->deployment)->toBe(['image' => 'nginx:1.20']);
});

test('users can deploy application resource to kubernetes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);
    ProjectResourceApplication::factory()->create(['project_resource_id' => $resource->id]);

    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/application/deploy");

    $response->assertJson(['message' => 'Applied patch']);
});

test('users can add a new port to application resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);
    $application = ProjectResourceApplication::factory()->create(['project_resource_id' => $resource->id, 'ports' => []]);
    $portData = [
        'hostPort' => 8080,
        'containerPort' => 80,
    ];

    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/application/ports", $portData);

    $response->assertRedirect();
    $application->refresh();
    expect($application->ports)->toHaveCount(1);
    expect($application->ports[0]['hostPort'])->toBe(8080);
    expect($application->ports[0]['containerPort'])->toBe(80);
    expect($application->ports[0])->toHaveKey('selector');
});

test('port creation validates input', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['team_id' => $user->currentTeam->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);
    ProjectResourceApplication::factory()->create(['project_resource_id' => $resource->id]);

    // Invalid port numbers
    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/application/ports", [
        'hostPort' => 0,
        'containerPort' => 80,
    ]);
    $response->assertSessionHasErrors('hostPort');

    $response = $this->actingAs($user)->post("projects/{$project->id}/{$resource->id}/application/ports", [
        'hostPort' => 8080,
        'containerPort' => 70000,
    ]);
    $response->assertSessionHasErrors('containerPort');
});

test('users can update a port in application resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);
    $application = ProjectResourceApplication::factory()->create([
        'project_resource_id' => $resource->id,
        'ports' => [['hostPort' => 80, 'containerPort' => 80, 'selector' => 'port1']],
    ]);
    $updateData = [
        'selector' => 'port1',
        'hostPort' => 8080,
        'containerPort' => 8080,
    ];

    $response = $this->actingAs($user)->put("projects/{$project->id}/{$resource->id}/application/ports", $updateData);

    $response->assertRedirect();
    $application->refresh();
    expect($application->ports[0]['hostPort'])->toBe(8080);
    expect($application->ports[0]['containerPort'])->toBe(8080);
});

test('users can delete a port from application resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create([
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);
    $application = ProjectResourceApplication::factory()->create([
        'project_resource_id' => $resource->id,
        'ports' => [['hostPort' => 80, 'containerPort' => 80, 'selector' => 'port1']],
    ]);
    $deleteData = ['selector' => 'port1'];

    $response = $this->actingAs($user)->delete("projects/{$project->id}/{$resource->id}/application/ports", $deleteData);

    $response->assertRedirect();
    $application->refresh();
    expect($application->ports)->toBeEmpty();
});
