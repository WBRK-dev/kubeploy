<?php

use App\Enums\ProjectResourceType;
use App\Models\Project;
use App\Models\ProjectResource;
use App\Models\ProjectResourceApplication;
use App\Models\ProjectResourceYaml;

test('project resource belongs to project', function () {
    $project = Project::factory()->create();
    $resource = ProjectResource::factory()->create(['project_id' => $project->id]);

    expect($resource->project)->toBeInstanceOf(Project::class);
    expect($resource->project->id)->toBe($project->id);
});

test('project resource has application trait', function () {
    $resource = ProjectResource::factory()->create(['type' => ProjectResourceType::Application->value]);
    ProjectResourceApplication::factory()->create(['project_resource_id' => $resource->id]);

    $resource->loadType();

    expect($resource->applicationTrait)->toBeInstanceOf(ProjectResourceApplication::class);
});

test('project resource has yaml trait', function () {
    $resource = ProjectResource::factory()->create(['type' => ProjectResourceType::Yaml->value]);
    ProjectResourceYaml::factory()->create(['project_resource_id' => $resource->id]);

    $resource->loadType();

    expect($resource->yamlTrait)->toBeInstanceOf(ProjectResourceYaml::class);
});

test('selector is generated on creating', function () {
    $project = Project::factory()->create(['name' => 'testproject']);
    $resource = ProjectResource::factory()->create(['project_id' => $project->id, 'name' => 'testresource']);

    expect($resource->selector)->toStartWith('testproject-testresource-');
});
