<?php

namespace Database\Factories;

use App\Models\ProjectResource;
use App\Models\ProjectResourceApplication;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectResourceApplication>
 */
class ProjectResourceApplicationFactory extends Factory
{
    protected $model = ProjectResourceApplication::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_resource_id' => ProjectResource::factory(),
            'deployment' => ['image' => 'nginx:latest'],
            'domains' => ['example.com'],
            'ports' => [['hostPort' => 80, 'containerPort' => 80, 'selector' => 'port1']],
        ];
    }
}
