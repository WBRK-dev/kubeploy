<?php

use App\Concerns\CreatesProjectResourceType;
use App\Enums\ProjectResourceType;
use App\Models\ProjectResource;
use Mockery;

test('creates application trait for application type', function () {
    $class = new class
    {
        use CreatesProjectResourceType;
    };

    $resource = Mockery::mock(ProjectResource::class);
    $resource->shouldReceive('getAttribute')->with('type')->andReturn(ProjectResourceType::Application->value);
    $trait = Mockery::mock();
    $resource->shouldReceive('applicationTrait')->andReturn($trait);
    $trait->shouldReceive('create')->once()->with([
        'deployment' => ['type' => 'docker'],
        'domains' => [],
        'ports' => [],
    ]);

    $class::createResourceTypeByType($resource);
});

test('creates yaml trait for yaml type', function () {
    $class = new class
    {
        use CreatesProjectResourceType;
    };

    $resource = Mockery::mock(ProjectResource::class);
    $resource->shouldReceive('getAttribute')->with('type')->andReturn(ProjectResourceType::Yaml->value);
    $trait = Mockery::mock();
    $resource->shouldReceive('yamlTrait')->andReturn($trait);
    $trait->shouldReceive('create')->once()->with([
        'yaml' => '',
    ]);

    $class::createResourceTypeByType($resource);
});
