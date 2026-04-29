<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $project_resource_id
 * @property string $yaml
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\ProjectResource $projectResource
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml whereProjectResourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProjectResourceYaml whereYaml($value)
 * @mixin \Eloquent
 */
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
