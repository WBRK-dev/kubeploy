<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectResource extends Model
{
    protected $fillable = [
        "project_id",
        "type",
    ];

    public function loadType(): void
    {
        switch($this->type) {
            case ("yaml"):
                $this->load("yamlTrait");
                break;
        }
    }

    public function yamlTrait(): HasMany
    {
        return $this->hasMany(ProjectResourceYaml::class);
    }
}
