<?php

use App\Models\ProjectResource;
use App\Models\ProjectResourceYaml;

test('project resource yaml belongs to project resource', function () {
    $resource = ProjectResource::factory()->create();
    $yaml = ProjectResourceYaml::factory()->create(['project_resource_id' => $resource->id]);

    expect($yaml->projectResource)->toBeInstanceOf(ProjectResource::class);
    expect($yaml->projectResource->id)->toBe($resource->id);
});
