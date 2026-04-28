<?php

namespace App\Models;

use App\Enums\ProjectResourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProjectResource extends Model
{
    protected $fillable = [
        "project_id",
        "type",
    ];

    public function loadType(): void
    {
        switch($this->type) {
            case (ProjectResourceType::Yaml->value):
                $this->load("yamlTrait");
                break;
        }
    }

    public function yamlTrait(): HasOne
    {
        return $this->hasOne(ProjectResourceYaml::class);
    }
}
