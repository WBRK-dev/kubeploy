<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository {
    public function __construct(
        protected TeamRepository $teamRepository,
    ) { }

    public function getById(int $id, string $teamSlug): ?Project
    {
        return $this->teamRepository->getBySlug($teamSlug)
            ?->projects()->with("resources.yamlTrait")?->findOrFail($id);
    }

    public function create(string $name, int $teamId): Project
    {
        return Project::create([
            'name' => $name,
            'team_id' => $teamId,
        ]);
    }
}
