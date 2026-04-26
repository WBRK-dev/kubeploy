<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        "name",
        "team_id",
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(ProjectResource::class);
    }
}
