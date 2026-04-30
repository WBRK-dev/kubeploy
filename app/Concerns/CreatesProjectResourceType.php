<?php

namespace App\Concerns;

use App\Enums\ProjectResourceType;
use App\Models\ProjectResource;

trait CreatesProjectResourceType
{
    protected static function createResourceTypeByType(ProjectResource $resource): void
    {
        switch ($resource->type) {
            case (ProjectResourceType::Yaml->value):
                $resource->yamlTrait()->create([
                    "yaml" => "",
                ]);
                break;
        }
    }
}
