<?php

use App\Models\Project;
use App\Models\Team;
use App\Models\User;

test('authenticated users can view projects index using routes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);

    $response = $this->actingAs($user)->get(route('projects'));

    $response->assertOk();
    $response->assertInertia(fn ($inertia) => $inertia
        ->has('projects', 1)
        ->where('projects.0.id', $project->id)
        ->where('projects.0.name', $project->name)
    );
});

test('users can create a new project using routes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $projectData = ['name' => 'Test Project'];

    $response = $this->actingAs($user)->post(route('projects'), $projectData);

    $response->assertRedirect();
    $this->assertDatabaseHas('projects', [
        'name' => 'Test Project',
        'team_id' => $team->id,
    ]);
});

test('project creation validates name using routes', function () {
    $user = User::factory()->create();

    // Missing name
    $response = $this->actingAs($user)->post(route('projects'), []);
    $response->assertSessionHasErrors('name');

    // Name too long
    $response = $this->actingAs($user)->post(route('projects'), ['name' => str_repeat('a', 21)]);
    $response->assertSessionHasErrors('name');
});

test('users can view a specific project using routes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);

    $response = $this->actingAs($user)->get(route('project', $project));

    $response->assertOk();
    $response->assertInertia(fn ($inertia) => $inertia
        ->has('project')
        ->where('project.id', $project->id)
        ->where('project.name', $project->name)
    );
});

test('users cannot view projects from other teams using routes', function () {
    $user = User::factory()->create();
    $otherTeam = Team::factory()->create();
    $project = Project::factory()->create(['team_id' => $otherTeam->id]);

    $response = $this->actingAs($user)->get(route('project', $project));

    $response->assertForbidden();
});

test('users can update a project using routes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);
    $updateData = ['name' => 'Updated Project'];

    $response = $this->actingAs($user)->put(route('projects.update', $project), $updateData);

    $response->assertRedirect();
    $project->refresh();
    expect($project->name)->toBe('Updated Project');
});

test('users can delete a project using routes', function () {
    $user = User::factory()->create();
    $team = $user->currentTeam;
    $project = Project::factory()->create(['team_id' => $team->id]);

    $response = $this->actingAs($user)->delete(route('projects.delete', $project));

    $response->assertRedirect();
    $this->assertDatabaseMissing('projects', ['id' => $project->id]);
});

