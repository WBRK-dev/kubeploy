<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectResourceYaml extends Model
{
    protected $fillable = [
        "project_resource_id",
        "yaml",
    ];

    public function projectResource(): BelongsTo
    {
        return $this->belongsTo(ProjectResource::class);
    }
}
