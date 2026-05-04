<?php

namespace Database\Factories;

use App\Models\ProjectResource;
use App\Models\ProjectResourceYaml;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectResourceYaml>
 */
class ProjectResourceYamlFactory extends Factory
{
    protected $model = ProjectResourceYaml::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_resource_id' => ProjectResource::factory(),
            'yaml' => "apiVersion: v1\nkind: ConfigMap\nmetadata:\n  name: example\n  namespace: default\ndata:\n  key: value",
        ];
    }
}
