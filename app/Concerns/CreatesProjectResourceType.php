<?php

namespace App\Concerns;

use App\Enums\ProjectResourceType;
use App\Models\ProjectResource;

trait CreatesProjectResourceType
{
    protected static function createResourceTypeByType(ProjectResource $resource): void
    {
        switch ($resource->type) {
            case (ProjectResourceType::Application->value):
                $resource->applicationTrait()->create([
                    'deployment' => ['type' => 'docker'],
                    'domains' => [],
                    'ports' => [],
                ]);
                break;
            case (ProjectResourceType::Yaml->value):
                $resource->yamlTrait()->create([
                    'yaml' => '',
                ]);
                break;
        }
    }
}
