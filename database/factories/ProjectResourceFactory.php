<?php

namespace Database\Factories;

use App\Enums\ProjectResourceType;
use App\Models\Project;
use App\Models\ProjectResource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjectResource>
 */
class ProjectResourceFactory extends Factory
{
    protected $model = ProjectResource::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'name' => $this->faker->word(),
            'type' => $this->faker->randomElement(ProjectResourceType::cases())->value,
            'selector' => null, // Will be generated
        ];
    }
}
