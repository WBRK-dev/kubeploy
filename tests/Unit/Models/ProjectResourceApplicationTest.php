<?php

use App\Models\ProjectResourceApplication;

test('project resource application casts arrays', function () {
    $application = ProjectResourceApplication::factory()->create([
        'deployment' => ['image' => 'nginx'],
        'domains' => ['example.com'],
        'ports' => [['port' => 80]],
    ]);

    expect($application->deployment)->toBeArray();
    expect($application->domains)->toBeArray();
    expect($application->ports)->toBeArray();
});
