<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\ProjectResourceType;
use App\Models\ProjectResource;

class ProjectResourceRepository {
    public function create(string $name, string $type, int $projectId): ProjectResource
    {
        /** @var ProjectResource $projectResource */
        $projectResource = ProjectResource::create([
            'name' => $name,
            'type' => $type,
            'project_id' => $projectId,
        ]);

        switch ($type) {
            case (ProjectResourceType::Yaml->value):
                $projectResource->yamlTrait()->create([
                    "yaml" => "",
                ]);
                break;
        }

        return $projectResource;
    }

    public function update(ProjectResource $resource): ProjectResource
    {
        $resource->save();
        return $resource;
    }

    public function delete(ProjectResource|int $resource): void
    {
        if (is_int($resource)) {
            ProjectResource::whereId($resource)->delete();
            return;
        }

        $resource->delete();
    }
}
