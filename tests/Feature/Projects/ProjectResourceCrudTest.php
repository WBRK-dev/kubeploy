<?php

use App\Enums\ProjectResourceType;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\Team;
use App\Models\User;

test('guests cannot access project resources', function () {
    $project = Project::factory()->create();
    $resource = ProjectResource::factory()->create(['project_id' => $project->id]);

    $response = $this->get(route('project.resource', [$project, $resource]));
    $response->assertRedirect(route('login'));
});

test('users can view a project resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create(['project_id' => $project->id]);

    $response = $this->actingAs($user)->get(route('project.resource', [$project, $resource]));

    $response->assertOk();
    $response->assertInertia(fn ($inertia) => $inertia
        ->has('project')
        ->has('resource')
        ->where('resource.id', $resource->id)
        ->where('resource.name', $resource->name)
    );
});

test('users cannot view resources from other teams', function () {
    $user = User::factory()->create();
    $otherTeam = Team::factory()->create();
    $project = Project::factory()->create(['team_id' => $otherTeam->id]);
    $resource = ProjectResource::factory()->create(['project_id' => $project->id]);

    $response = $this->actingAs($user)->get(route('project.resource', [$project, $resource]));
    $response->assertForbidden();
});

test('users can create a new project resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resourceData = [
        'name' => 'Test Resource',
        'type' => ProjectResourceType::Application->value,
    ];

    $response = $this->actingAs($user)->post("projects/{$project->id}", $resourceData);

    $response->assertRedirect();
    $this->assertDatabaseHas('project_resources', [
        'name' => 'Test Resource',
        'project_id' => $project->id,
        'type' => ProjectResourceType::Application->value,
    ]);
});

test('resource creation validates input', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['team_id' => $user->currentTeam->id]);

    // Missing name
    $response = $this->actingAs($user)->post("projects/{$project->id}", ['type' => ProjectResourceType::Application->value]);
    $response->assertSessionHasErrors('name');

    // Invalid type
    $response = $this->actingAs($user)->post("projects/{$project->id}", ['name' => 'Test', 'type' => 'invalid']);
    $response->assertSessionHasErrors('type');
});

test('users can update a project resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create(['project_id' => $project->id]);
    $updateData = ['name' => 'Updated Resource'];

    $response = $this->actingAs($user)->put("projects/{$project->id}/{$resource->id}", $updateData);

    $response->assertRedirect();
    $resource->refresh();
    expect($resource->name)->toBe('Updated Resource');
});

test('users can delete a project resource', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $resource = ProjectResource::factory()->create(['project_id' => $project->id]);

    $response = $this->actingAs($user)->delete("projects/{$project->id}/{$resource->id}");

    $response->assertRedirect();
    $this->assertDatabaseMissing('project_resources', ['id' => $resource->id]);
});

test('resource selector is generated uniquely', function () {
    $user = User::factory()->create();
    $project = Project::factory()->create(['team_id' => $user->currentTeam->id]);

    $resource1 = ProjectResource::factory()->create(['project_id' => $project->id, 'name' => 'test']);
    $resource2 = ProjectResource::factory()->create(['project_id' => $project->id, 'name' => 'test']);

    expect($resource1->selector)->not->toBeNull();
    expect($resource2->selector)->not->toBeNull();
    expect($resource1->selector)->not->toBe($resource2->selector);
});
